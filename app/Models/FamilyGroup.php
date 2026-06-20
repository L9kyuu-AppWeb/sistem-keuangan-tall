<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class FamilyGroup extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $familyGroup) {
            $familyGroup->code = strtoupper(Str::random(8));
        });
    }

    public function members(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
