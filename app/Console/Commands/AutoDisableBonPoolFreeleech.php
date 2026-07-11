<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\BonPool;
use Illuminate\Console\Command;

class AutoDisableBonPoolFreeleech extends Command
{
    protected $signature = 'auto:disable-bon-pool-freeleech';

    protected $description = 'Expire BON Pool freeleech once the reward period ends';

    public function handle(): void
    {
        $pool = BonPool::find(1);

        if ($pool === null || $pool->freeleech_until === null) {
            return;
        }

        if ($pool->freeleech_until->isPast()) {
            $pool->update(['freeleech_until' => null]);
            cache()->forget('bon_pool_freeleech_active');

            $this->info('BON Pool freeleech expired and has been disabled.');
        }
    }
}
