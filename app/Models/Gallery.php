<?php

namespace App\Models;

use App\Models\Concerns\HasContentScopes;
use App\Models\Concerns\HasManagedImage;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasContentScopes;
    use HasManagedImage;

    protected $fillable = [
        'title',
        'caption',
        'category',
        'image_path',
        'image_alt',
        'focal_point',
        'aspect_ratio',
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

    public static function allowedAspectRatios(): array
    {
        return ['landscape', 'portrait', 'square', 'wide'];
    }
}
