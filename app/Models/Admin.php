<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    public function destinations(): HasMany
    {
        return $this->hasMany(Destination::class, 'updated_by');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'updated_by');
    }

    public function umkm(): HasMany
    {
        return $this->hasMany(Umkm::class, 'updated_by');
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class, 'updated_by');
    }
}
