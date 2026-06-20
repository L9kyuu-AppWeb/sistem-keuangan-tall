<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilyGroup extends Model
{
    protected $fillable = ['name', 'code'];

    public function members(): HasMany
    {
        return $this->hasMany(User::class, 'family_group_id');
    }

    public function owner()
    {
        return $this->members()->where('family_role', 'owner')->first();
    }

    public static function generateCode(): string
    {
        do {
            $code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
        } while (self::where('code', $code)->exists());

        return $code;
    }
}
