<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoldHolding extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'grams',
        'price_per_gram',
        'total_cost',
        'date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'grams' => 'decimal:3',
            'price_per_gram' => 'decimal:2',
            'total_cost' => 'decimal:2',
            'date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
