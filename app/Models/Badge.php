<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Badge extends Model
{
    protected $guarded = [];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_badges')
            ->withPivot('awarded_at')
            ->withTimestamps();
    }

    public function categoryLabel(): string
    {
        return match ($this->category) {
            'anniversary' => 'Ulang Tahun',
            'uploader'    => 'Penyumbang Kandungan',
            'seeder'      => 'Pelayar Setia',
            'ratio'       => 'Nisbah Cemerlang',
            'community'   => 'Komuniti',
            'special'     => 'Khas',
            default       => ucfirst($this->category),
        };
    }
}
