<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => mb_strtolower($value, 'UTF-8'),
        );
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Hash::make($value),
        );
    }

    public static array $sortable = ['id', 'email', 'created_at', 'updated_at'];
}
