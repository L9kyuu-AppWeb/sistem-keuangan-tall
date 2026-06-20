<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'icon',
        'is_system',
    ];

    protected function casts(): array
    {
        return [
            'is_system' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public static function defaultSystemCategories(): array
    {
        return [
            ['name' => 'Belanja', 'icon' => 'shopping-cart'],
            ['name' => 'Tagihan', 'icon' => 'bolt'],
            ['name' => 'Makan', 'icon' => 'soup'],
            ['name' => 'Transport', 'icon' => 'car'],
            ['name' => 'Hiburan', 'icon' => 'device-tv'],
            ['name' => 'Kesehatan', 'icon' => 'heart-rate-monitor'],
            ['name' => 'Pendidikan', 'icon' => 'school'],
            ['name' => 'Lainnya', 'icon' => 'dots'],
        ];
    }
}
