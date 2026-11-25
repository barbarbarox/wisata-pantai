<?php

namespace App\Models;

use App\Models\Concerns\HasContentScopes;
use App\Models\Concerns\HasManagedImage;
use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasContentScopes;
    use HasManagedImage;
    use HasUniqueSlug;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'short_description',
        'description',
        'additional_info',
        'image_path',
        'image_alt',
        'focal_point',
        'is_featured',
        'is_active',
        'sort_order',
        'updated_by',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
