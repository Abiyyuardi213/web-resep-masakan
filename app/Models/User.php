<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'username',
        'email',
        'no_telepon',
        'password',
        'profile_picture',
        'role_id',
        'is_member',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_member' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            if (!$user->id) {
                $user->id = (string) Str::uuid();
            }
        });
    }

    public function getAuthIdentifierName()
    {
        return 'username';
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function isAdmin()
    {
        return strtolower($this->role->role_name) === 'admin';
    }

    public function deleteUser()
    {
        return $this->delete();
    }

    public function likes()
    {
        return $this->hasMany(\App\Models\Likes::class);
    }
}
