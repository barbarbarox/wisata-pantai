<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Services\MediaService;
use Illuminate\Http\Request;

trait HandlesContentImages
{
    /**
     * Resolve uploaded, existing managed, or removed image path for a content record.
     *
     * @return array{should_update: bool, path: ?string, old_path: ?string}
     */
    protected function resolveImageInput(
        Request $request,
        MediaService $media,
        string $subdirectory,
        ?string $currentPath = null,
        bool $allowRemove = true
    ): array {
        if ($allowRemove && $request->boolean('remove_image')) {
            return [
                'should_update' => true,
                'path' => null,
                'old_path' => $currentPath,
            ];
        }

        if ($request->hasFile('image')) {
            return [
                'should_update' => true,
                'path' => $media->upload($request->file('image'), $subdirectory),
                'old_path' => $currentPath,
            ];
        }

        $existing = $request->input('existing_image');
        if (is_string($existing) && $existing !== '' && $media->isManagedPath($existing)) {
            return [
                'should_update' => true,
                'path' => $existing,
                'old_path' => $currentPath,
            ];
        }

        return [
            'should_update' => false,
            'path' => $currentPath,
            'old_path' => null,
        ];
    }

    protected function cleanupReplacedImage(MediaService $media, ?string $oldPath, ?string $newPath): void
    {
        if ($oldPath && $oldPath !== $newPath) {
            $media->deleteIfUnused($oldPath);
        }
    }
}

