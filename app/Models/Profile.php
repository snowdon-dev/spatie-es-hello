<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'username',
        'userId',
    ];

    /*
     * A helper method to quickly retrieve an account by uuid.
     */
    public static function uuid(string $uuid): ?Profile
    {
        return static::where('uuid', $uuid)->first();
    }
}
