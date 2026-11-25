<?php

namespace App\Models;

use App\Models\Concerns\HasContentScopes;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasContentScopes;

    protected $fillable = [
        'platform',
        'label',
        'url',
        'icon',
        'is_active',
        'sort_order',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
