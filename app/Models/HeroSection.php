<?php

namespace App\Models;

use App\Models\Concerns\HasContentScopes;
use App\Models\Concerns\HasManagedImage;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasContentScopes;
    use HasManagedImage;

    protected $fillable = [
        'eyebrow',
        'title',
        'subtitle',
        'primary_cta_text',
        'primary_cta_url',
        'secondary_cta_text',
        'secondary_cta_url',
        'background_image',
        'image_alt',
        'focal_point',
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

    protected function imageColumn(): string
    {
        return 'background_image';
    }
}
