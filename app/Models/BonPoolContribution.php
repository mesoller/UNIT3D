<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class BonPoolContribution extends Model
{
    protected $fillable = ['user_id', 'amount', 'anonymous'];

    protected function casts(): array
    {
        return [
            'amount'    => 'decimal:2',
            'anonymous' => 'bool',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
