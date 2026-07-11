<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

final class BonPool extends Model
{
    protected $table = 'bon_pool';

    protected $fillable = ['cycle_started_at', 'freeleech_until'];

    protected function casts(): array
    {
        return [
            'cycle_started_at' => 'datetime',
            'freeleech_until'  => 'datetime',
        ];
    }

    public static function instance(): static
    {
        return static::firstOrCreate(['id' => 1], [
            'cycle_started_at' => now(),
            'freeleech_until'  => null,
        ]);
    }

    public static function isFreeleechActive(): bool
    {
        return cache()->remember('bon_pool_freeleech_active', 60, function (): bool {
            $pool = static::find(1);

            return $pool !== null
                && $pool->freeleech_until !== null
                && $pool->freeleech_until->isFuture();
        });
    }

    public function cycleTotal(): float
    {
        return (float) BonPoolContribution::where('created_at', '>=', $this->cycle_started_at)
            ->sum('amount');
    }
}
