<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan',
        'status',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'trial_starts_at',
        'trial_ends_at',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'trial_starts_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isActive()
    {
        if ($this->status === 'trial') {
            return $this->trial_ends_at && $this->trial_ends_at->isFuture();
        }

        if ($this->status === 'active') {
            return $this->ends_at && $this->ends_at->isFuture();
        }

        return false;
    }
}
