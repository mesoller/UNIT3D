<?php

declare(strict_types=1);

/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D Community Edition is open-sourced software licensed under the GNU Affero General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D Community Edition
 *
 * @author     HDVinnie <hdinnovations@protonmail.com>
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 */

namespace App\Console\Commands;

use App\Repositories\ChatRepository;
use Illuminate\Console\Command;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class AutoNerdStat extends Command
{
    /**
     * AutoNerdStat Constructor.
     */
    public function __construct(private readonly ChatRepository $chatRepository)
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:nerdstat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically posts daily nerd stat to shoutbox';

    /**
     * Execute the console command.
     *
     * @throws Exception|Throwable If there is an error during the execution of the command.
     */
    final public function handle(): void
    {
        // Check if the nerd bot is enabled in the configuration.
        if (!config('chat.nerd_bot')) {
            return;
        }

        // Define the possible stats.
        $stats = collect([
            'birthday',
            'logins',
            'uploads',
            'users',
            'fl25',
            'fl50',
            'fl75',
            'fl100',
            'du',
            'peers',
            'bans',
            'unbans',
            'warnings',
            'king',
        ])->random();

        // Generate the message based on the selected stat.
        $message = match ($stats) {
            'birthday' => config('other.title').' Ditubuhkan Pada [b]'.config('other.birthdate').'[/b]!',
            'logins'   => 'Dalam tempoh 24 jam lepas [color=#93c47d][b]'.DB::table('users')->whereNotNull('last_login')->where('last_login', '>', now()->subDay())->count().'[/b][/color] pengguna unik telah log masuk ke '.config('other.title').'!',
            'uploads'  => 'Dalam tempoh 24 jam lepas [color=#93c47d][b]'.DB::table('torrents')->where('created_at', '>', now()->subDay())->count().'[/b][/color] torrent telah dimuat naik ke '.config('other.title').'!',
            'users'    => 'Dalam tempoh 24 jam lepas [color=#93c47d][b]'.DB::table('users')->where('created_at', '>', now()->subDay())->count().'[/b][/color] pengguna telah mendaftar di '.config('other.title').'!',
            'fl25'     => 'Terdapat [color=#93c47d][b]'.DB::table('torrents')->where('free', '=', 25)->count().'[/b][/color] torrent freeleech 25% di '.config('other.title').' pada masa ini!',
            'fl50'     => 'Terdapat [color=#93c47d][b]'.DB::table('torrents')->where('free', '=', 50)->count().'[/b][/color] torrent freeleech 50% di '.config('other.title').' pada masa ini!',
            'fl75'     => 'Terdapat [color=#93c47d][b]'.DB::table('torrents')->where('free', '=', 75)->count().'[/b][/color] torrent freeleech 75% di '.config('other.title').' pada masa ini!',
            'fl100'    => 'Terdapat [color=#93c47d][b]'.DB::table('torrents')->where('free', '=', 100)->count().'[/b][/color] torrent freeleech 100% di '.config('other.title').' pada masa ini!',
            'du'       => 'Terdapat [color=#93c47d][b]'.DB::table('torrents')->where('doubleup', '=', 1)->count().'[/b][/color] torrent muat naik berganda di '.config('other.title').' pada masa ini!',
            'peers'    => 'Pada masa ini terdapat [color=#93c47d][b]'.DB::table('peers')->where('active', '=', 1)->count().'[/b][/color] peers di '.config('other.title').'!',
            'bans'     => 'Dalam tempoh 24 jam lepas [color=#dd7e6b][b]'.DB::table('bans')->whereNotNull('ban_reason')->where('created_at', '>', now()->subDay())->count().'[/b][/color] pengguna telah diharamkan dari '.config('other.title').'!',
            'unbans'   => 'Dalam tempoh 24 jam lepas [color=#dd7e6b][b]'.DB::table('bans')->whereNotNull('unban_reason')->where('removed_at', '>', now()->subDay())->count().'[/b][/color] pengguna telah dinyahsekat dari '.config('other.title').'!',
            'warnings' => 'Dalam tempoh 24 jam lepas [color=#dd7e6b][b]'.DB::table('warnings')->where('created_at', '>', now()->subDay())->count().'[/b][/color] amaran lari tanpa seed telah dikeluarkan di '.config('other.title').'!',
            'king'     => config('other.title').' adalah raja!',
            default    => 'Ralat statistik!',
        };

        // Post the message to the chatbox.
        $this->chatRepository->systemMessage($message);

        // Output a success message to the console.
        $this->comment('Automated nerd stat command complete');
    }
}
