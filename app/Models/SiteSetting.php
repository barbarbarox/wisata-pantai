<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\File;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'group',
        'label',
        'type',
        'value',
        'updated_by',
    ];

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public static function imageUrlFor(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $normalized = ltrim($path, '/');

        if (File::exists(public_path('storage/'.$normalized))) {
            return '/storage/'.$normalized;
        }

        $basename = basename($normalized);
        if (File::exists(public_path('seed-media/'.$basename))) {
            return '/seed-media/'.$basename;
        }

        return '/storage/'.$normalized;
    }
}
