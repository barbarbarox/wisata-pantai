<?php

namespace App\Models\Concerns;

trait HasManagedImage
{
    protected function imageColumn(): string
    {
        return 'image_path';
    }

    public function getImageUrlAttribute(): ?string
    {
        $column = $this->imageColumn();
        $path = $this->{$column} ?? null;

        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return '/storage/'.ltrim($path, '/');
    }

    public function getFocalPointStyleAttribute(): string
    {
        $point = $this->focal_point ?? 'center center';

        return in_array($point, self::allowedFocalPoints(), true) ? $point : 'center center';
    }

    public static function allowedFocalPoints(): array
    {
        return [
            'center center',
            'top center',
            'bottom center',
            'left center',
            'right center',
            'top left',
            'top right',
            'bottom left',
            'bottom right',
        ];
    }
}

