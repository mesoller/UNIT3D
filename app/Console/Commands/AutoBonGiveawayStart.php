<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\BonGiveaway;
use App\Models\User;
use App\Repositories\ChatRepository;
use Illuminate\Console\Command;

class AutoBonGiveawayStart extends Command
{
    protected $signature = 'auto:bon-giveaway-start';

    protected $description = 'Start an automatic BON giveaway in the chatbox';

    public function __construct(private readonly ChatRepository $chat)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        // Skip if a giveaway is already running
        if (BonGiveaway::active() !== null) {
            $this->info('A giveaway is already active. Skipping.');

            return;
        }

        $amount    = (int) config('bon_giveaway.amount');
        $duration  = (int) config('bon_giveaway.duration_minutes');
        $startNum  = (int) config('bon_giveaway.start_num');
        $endNum    = (int) config('bon_giveaway.end_num');
        $reminders = (int) config('bon_giveaway.reminders');
        $botUserId = (int) config('bon_giveaway.bot_user_id');

        // Verify the funding user has enough BON
        $botUser = User::find($botUserId);

        if ($botUser === null || $botUser->seedbonus < $amount) {
            $this->error('Bot user does not have enough BON to fund the giveaway.');

            return;
        }

        $winningNumber   = random_int($startNum, $endNum);
        $durationSeconds = $duration * 60;
        $reminderInterval = $reminders > 0
            ? (int) floor($durationSeconds / ($reminders + 1))
            : 0;

        $chatroomId = $this->chat->systemChatroom();

        $giveaway = BonGiveaway::create([
            'amount'                   => $amount,
            'winning_number'           => $winningNumber,
            'start_num'                => $startNum,
            'end_num'                  => $endNum,
            'chatroom_id'              => $chatroomId,
            'last_message_id'          => $this->latestMessageId($chatroomId),
            'reminder_interval_seconds' => $reminderInterval,
            'next_reminder_at'         => $reminderInterval > 0
                ? now()->addSeconds($reminderInterval)
                : null,
            'starts_at' => now(),
            'ends_at'   => now()->addMinutes($duration),
        ]);

        $this->chat->systemMessage(
            sprintf(
                '[b][color=#ffc00a]🎁 AUTO GIVEAWAY![/color][/b] MalayaBits memberikan [b][color=#ffc00a]%s BON[/color][/b]! '
                .'Taip nombor [b][color=red]%d–%d[/color][/b] dalam chat untuk menyertai.',
                number_format($amount),
                $startNum,
                $endNum
            )
        );

        $this->chat->systemMessage(
            sprintf(
                '⏳ Giveaway tamat dalam [b][color=green]%d minit[/color][/b]. '
                .'Pemenang = yang paling hampir dengan nombor rahsia. Semoga berjaya!',
                $duration
            )
        );

        $this->info("Giveaway #{$giveaway->id} started. Winning number: {$winningNumber}. Ends at: {$giveaway->ends_at}");
    }

    private function latestMessageId(int $chatroomId): int
    {
        return \App\Models\Message::where('chatroom_id', $chatroomId)->max('id') ?? 0;
    }
}
