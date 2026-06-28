<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\User;
use App\Notifications\NewWelcome;
use App\Repositories\ChatRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Arr;

readonly class RegisteredListener
{
    public function __construct(private ChatRepository $chatRepository)
    {
    }

    public function __invoke(Registered $event): void
    {
        /** @var User $user */
        $user = $event->user;

        $this->chatRepository->systemMessage($this->getWelcomeMessage($user));

        // Send Welcome PM
        $user->notify(new NewWelcome());
    }

    private function getWelcomeMessage(User $user): string
    {
        // Select A Random Welcome Message
        $profileUrl = href_profile($user);

        return Arr::random([
            \sprintf('[url=%s]%s[/url], Selamat datang ke ', $profileUrl, $user->username).config('other.title').'! Semoga anda menikmati komuniti ini.',
            \sprintf("[url=%s]%s[/url], kami sudah menunggu anda.", $profileUrl, $user->username),
            \sprintf("[url=%s]%s[/url] telah tiba. Parti sudah tamat.", $profileUrl, $user->username),
            \sprintf("Burung ke? Kapal terbang ke? Alah, itu cuma [url=%s]%s[/url].", $profileUrl, $user->username),
            \sprintf('Pemain bersedia [url=%s]%s[/url].', $profileUrl, $user->username),
            \sprintf('Seekor [url=%s]%s[/url] liar telah muncul.', $profileUrl, $user->username),
            'Selamat datang ke '.config('other.title').\sprintf(' [url=%s]%s[/url]. Kami sudah menjangkakan kehadiran anda.', $profileUrl, $user->username),
        ]);
    }
}
