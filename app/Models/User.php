<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'is_pro', 'pro_expires_at', 'trial_used_at', 'family_group_id', 'family_role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_pro' => 'boolean',
            'pro_expires_at' => 'datetime',
        ];
    }

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function goldHoldings(): HasMany
    {
        return $this->hasMany(GoldHolding::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(UserNotification::class);
    }

    public function familyGroup(): BelongsTo
    {
        return $this->belongsTo(FamilyGroup::class);
    }

    public function hasUsedTrial(): bool
    {
        return $this->trial_used_at !== null;
    }

    public function markTrialUsed(): void
    {
        $this->trial_used_at = now();
        $this->save();
    }

    public function isPro(): bool
    {
        return $this->is_pro && $this->pro_expires_at?->isFuture();
    }

    public function walletLimit(): int
    {
        return $this->isPro() ? PHP_INT_MAX : 2;
    }

    public function budgetLimit(): int
    {
        return $this->isPro() ? PHP_INT_MAX : 1;
    }
}
