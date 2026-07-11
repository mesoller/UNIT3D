<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\BonGiveaway;
use App\Models\BonGiveawayEntry;
use App\Models\Gift;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewBon;
use App\Repositories\ChatRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AutoBonGiveawayProcess extends Command
{
    protected $signature = 'auto:bon-giveaway-process';

    protected $description = 'Process entries and end active BON giveaway when time expires';

    public function __construct(private readonly ChatRepository $chat)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $giveaway = BonGiveaway::active();

        if ($giveaway === null) {
            return;
        }

        $this->processNewMessages($giveaway);
        $giveaway->refresh();

        // Send reminder if due
        if ($giveaway->next_reminder_at !== null && now()->greaterThanOrEqualTo($giveaway->next_reminder_at)) {
            $this->sendReminder($giveaway);

            $nextReminder = $giveaway->next_reminder_at->addSeconds($giveaway->reminder_interval_seconds);

            // Only schedule next reminder if it's before the end time
            $giveaway->update([
                'next_reminder_at' => $nextReminder->lessThan($giveaway->ends_at) ? $nextReminder : null,
            ]);
        }

        // End the giveaway if expired or all slots are filled
        $totalSlots = $giveaway->totalSlots();
        $entryCount = $giveaway->entries()->count();
        $allSlotsFilled = $entryCount >= $totalSlots;

        if ($giveaway->isExpired() || $allSlotsFilled) {
            if ($allSlotsFilled) {
                $this->chat->systemMessage(
                    \sprintf(
                        '[b][color=#ffc00a]Semua %d slot giveaway telah diisi![/color][/b] Giveaway ditamatkan lebih awal!',
                        $totalSlots
                    )
                );
            }

            $this->endGiveaway($giveaway);
        }
    }

    private function processNewMessages(BonGiveaway $giveaway): void
    {
        $newMessages = Message::where('chatroom_id', $giveaway->chatroom_id)
            ->where('id', '>', $giveaway->last_message_id)
            ->whereNull('bot_id')
            ->whereNull('receiver_id')
            ->where('user_id', '!=', User::SYSTEM_USER_ID)
            ->orderBy('id')
            ->get(['id', 'user_id', 'message']);

        if ($newMessages->isEmpty()) {
            return;
        }

        foreach ($newMessages as $msg) {
            $text = trim($msg->message);

            // Only process pure integer messages
            if (preg_match('/^-?\d+$/', $text)) {
                $this->handleEntry($giveaway, $msg->user_id, (int) $text);
            }
        }

        $giveaway->update(['last_message_id' => $newMessages->last()->id]);
    }

    private function handleEntry(BonGiveaway $giveaway, int $userId, int $number): void
    {
        // Ignore System user
        if ($userId === User::SYSTEM_USER_ID) {
            return;
        }

        $user = User::find($userId);

        if ($user === null) {
            return;
        }

        // Already entered
        if ($giveaway->entries()->where('user_id', $userId)->exists()) {
            $existing = $giveaway->entries()->where('user_id', $userId)->value('entry_number');
            $this->chat->systemMessage(
                \sprintf(
                    'Maaf [color=#d85e27]%s[/color], anda sudah masuk dengan nombor [color=red][b]%d[/b][/color]!',
                    $user->username,
                    $existing
                )
            );

            return;
        }

        // Out of range
        if ($number < $giveaway->start_num || $number > $giveaway->end_num) {
            $this->chat->systemMessage(
                \sprintf(
                    'Maaf [color=#d85e27]%s[/color], nombor [color=red][b]%d[/b][/color] di luar julat! Sila pilih nombor antara [b]%d dan %d[/b].',
                    $user->username,
                    $number,
                    $giveaway->start_num,
                    $giveaway->end_num
                )
            );

            return;
        }

        // Number already taken
        if ($giveaway->entries()->where('entry_number', $number)->exists()) {
            $takenBy = $giveaway->entries()->where('entry_number', $number)
                ->join('users', 'users.id', '=', 'bon_giveaway_entries.user_id')
                ->value('users.username');

            $this->chat->systemMessage(
                \sprintf(
                    'Maaf [color=#d85e27]%s[/color], nombor [color=red][b]%d[/b][/color] sudah diambil oleh [color=#32cd53]%s[/color]! Cuba nombor lain.',
                    $user->username,
                    $number,
                    $takenBy
                )
            );

            return;
        }

        BonGiveawayEntry::create([
            'giveaway_id'  => $giveaway->id,
            'user_id'      => $userId,
            'entry_number' => $number,
        ]);

        $this->chat->systemMessage(
            \sprintf(
                '✅ [color=#d85e27]%s[/color] telah menyertai giveaway dengan nombor [color=red][b]%d[/b][/color]! Semoga berjaya!',
                $user->username,
                $number
            )
        );
    }

    private function sendReminder(BonGiveaway $giveaway): void
    {
        $secondsLeft = now()->diffInSeconds($giveaway->ends_at, false);

        if ($secondsLeft <= 0) {
            return;
        }

        $timeLeft = $this->formatTime($secondsLeft);

        $this->chat->systemMessage(
            \sprintf(
                '[b][color=#ffc00a]⏰ PERINGATAN![/color][/b] Giveaway [b][color=#ffc00a]%s BON[/color][/b] — '
                .'[b][color=green]%s[/color][/b] lagi! Taip nombor [b][color=red]%d–%d[/color][/b] untuk menyertai.',
                number_format($giveaway->amount),
                $timeLeft,
                $giveaway->start_num,
                $giveaway->end_num
            )
        );
    }

    private function endGiveaway(BonGiveaway $giveaway): void
    {
        $entries = $giveaway->entries()->with('user')->get();

        if ($entries->isEmpty()) {
            $this->chat->systemMessage(
                '[b][color=#ffc00a]Giveaway tamat![/color][/b] Malangnya tiada siapa yang menyertai kali ini. Cuba lagi nanti!'
            );

            $giveaway->update(['ended_at' => now()]);

            return;
        }

        // Find the entry closest to the winning number (tie goes to the earliest entry)
        $winning = $giveaway->winning_number;
        $winner = $entries->sortBy([
            fn ($a, $b) => abs($a->entry_number - $winning) <=> abs($b->entry_number - $winning),
            fn ($a, $b) => $a->id <=> $b->id,   // earliest entry wins ties
        ])->first();

        // Transfer BON from bot user to winner
        $botUserId = (int) config('bon_giveaway.bot_user_id');
        $botUser = User::find($botUserId);
        $amount = $giveaway->amount;

        DB::transaction(function () use ($winner, $botUser, $amount, $giveaway): void {
            $winner->user->increment('seedbonus', $amount);

            if ($botUser !== null) {
                $botUser->decrement('seedbonus', $amount);
            }

            $gift = Gift::create([
                'sender_id'    => $botUser?->id ?? User::SYSTEM_USER_ID,
                'recipient_id' => $winner->user_id,
                'bon'          => $amount,
                'message'      => 'Tahniah! Anda memenangi Auto Giveaway BON!',
            ]);

            $winner->user->notify(new NewBon($gift));

            $giveaway->update([
                'ended_at'       => now(),
                'winner_user_id' => $winner->user_id,
            ]);
        });

        $diff = abs($winner->entry_number - $winning);

        if ($diff === 0) {
            $distanceText = \sprintf(
                'tepat dengan nombor rahsia [b][color=green]%d[/color][/b]',
                $winning
            );
        } else {
            $distanceText = \sprintf(
                'hanya [b][color=green]%d[/color][/b] angka jauh dari nombor rahsia [b][color=green]%d[/color][/b]',
                $diff,
                $winning
            );
        }

        $this->chat->systemMessage(
            \sprintf(
                '[b]🏆 TAHNIAH [color=red]%s[/color]![/b] Dengan tebakan [b][color=green]%d[/color][/b] (%s), '
                .'anda memenangi [b][color=#ffc00a]%s BON[/color][/b]! BON telah dikreditkan ke akaun anda.',
                $winner->user->username,
                $winner->entry_number,
                $distanceText,
                number_format($amount)
            )
        );

        $this->info("Giveaway #{$giveaway->id} ended. Winner: {$winner->user->username} ({$winner->entry_number} vs {$winning}).");
    }

    private function formatTime(int $seconds): string
    {
        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);
        $secs = $seconds % 60;

        $parts = [];

        if ($hours > 0) {
            $parts[] = "{$hours} jam";
        }

        if ($minutes > 0) {
            $parts[] = "{$minutes} minit";
        }

        if ($secs > 0 && $hours === 0) {
            $parts[] = "{$secs} saat";
        }

        return implode(', ', $parts) ?: '0 saat';
    }
}
