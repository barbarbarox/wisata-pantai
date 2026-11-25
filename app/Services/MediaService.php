<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Destination;
use App\Models\Gallery;
use App\Models\HeroSection;
use App\Models\SiteSetting;
use App\Models\Umkm;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class MediaService
{
    public const ROOT_DIR = 'media';

    public function upload(UploadedFile $file, string $subdirectory = 'uploads', ?string $previousPath = null): string
    {
        $cleanSubdir = trim(preg_replace('/[^a-zA-Z0-9_-]/', '', $subdirectory) ?: 'uploads', '/');
        $extension = strtolower($file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'webp');
        $filename = Str::uuid()->toString().'.'.$extension;
        $targetDir = self::ROOT_DIR.'/'.$cleanSubdir;

        $storedPath = $file->storeAs($targetDir, $filename, 'public');

        if (! $storedPath) {
            throw new InvalidArgumentException('Gagal menyimpan file gambar ke storage.');
        }

        if ($previousPath && $previousPath !== $storedPath) {
            $this->deleteIfUnused($previousPath);
        }

        return $storedPath;
    }

    public function seedAsset(string $filename, string $subdirectory = 'seeded'): ?string
    {
        $source = resource_path('seed-media/'.$filename);
        if (! File::exists($source)) {
            return null;
        }

        $relativePath = self::ROOT_DIR.'/'.$subdirectory.'/'.$filename;
        $disk = Storage::disk('public');

        if (! $disk->exists($relativePath)) {
            $disk->put($relativePath, File::get($source));
        }

        if (function_exists('posix_geteuid') && posix_geteuid() === 0) {
            $fullDir = $disk->path(self::ROOT_DIR.'/'.$subdirectory);
            $fullRoot = $disk->path(self::ROOT_DIR);
            $fullFile = $disk->path($relativePath);
            @chown($fullRoot, 'www-data');
            @chgrp($fullRoot, 'www-data');
            @chown($fullDir, 'www-data');
            @chgrp($fullDir, 'www-data');
            @chown($fullFile, 'www-data');
            @chgrp($fullFile, 'www-data');
        }

        return $relativePath;
    }

    public function deleteIfUnused(?string $path): bool
    {
        if (! $this->isManagedPath($path)) {
            return false;
        }

        if ($this->isPathReferenced($path)) {
            return false;
        }

        return Storage::disk('public')->delete($path);
    }

    public function forceDeleteManaged(?string $path): bool
    {
        if (! $this->isManagedPath($path)) {
            return false;
        }

        return Storage::disk('public')->delete($path);
    }

    public function isManagedPath(?string $path): bool
    {
        if (! $path || str_contains($path, '..') || str_contains($path, "\0")) {
            return false;
        }

        $normalized = ltrim($path, '/');

        return str_starts_with($normalized, self::ROOT_DIR.'/')
            && Storage::disk('public')->exists($normalized);
    }

    public function isPathReferenced(string $path): bool
    {
        $normalized = ltrim($path, '/');

        return HeroSection::where('background_image', $normalized)->exists()
            || Destination::where('image_path', $normalized)->exists()
            || Activity::where('image_path', $normalized)->exists()
            || Umkm::where('image_path', $normalized)->exists()
            || Gallery::where('image_path', $normalized)->exists()
            || SiteSetting::where('type', 'image')->where('value', $normalized)->exists();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listManagedFiles(): array
    {
        $disk = Storage::disk('public');
        if (! $disk->exists(self::ROOT_DIR)) {
            return [];
        }

        $references = $this->collectReferenceMap();
        $files = [];

        foreach ($disk->allFiles(self::ROOT_DIR) as $file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                continue;
            }

            $files[] = [
                'path' => $file,
                'url' => '/storage/'.$file,
                'name' => basename($file),
                'folder' => dirname($file),
                'size_kb' => round($disk->size($file) / 1024, 1),
                'last_modified' => $disk->lastModified($file),
                'used_in' => $references[$file] ?? [],
            ];
        }

        usort($files, fn (array $a, array $b) => $b['last_modified'] <=> $a['last_modified']);

        return $files;
    }

    /**
     * @return array<string, array<int, string>>
     */
    private function collectReferenceMap(): array
    {
        $map = [];
        $add = function (?string $path, string $label) use (&$map): void {
            if ($path) {
                $map[ltrim($path, '/')][] = $label;
            }
        };

        HeroSection::all(['title', 'background_image'])->each(fn ($h) => $add($h->background_image, 'Hero: '.$h->title));
        Destination::all(['name', 'image_path'])->each(fn ($d) => $add($d->image_path, 'Destinasi: '.$d->name));
        Activity::all(['title', 'image_path'])->each(fn ($a) => $add($a->image_path, 'Aktivitas: '.$a->title));
        Umkm::all(['business_name', 'image_path'])->each(fn ($u) => $add($u->image_path, 'UMKM: '.$u->business_name));
        Gallery::all(['title', 'image_path'])->each(fn ($g) => $add($g->image_path, 'Galeri: '.$g->title));
        SiteSetting::where('type', 'image')->get(['label', 'value'])->each(fn ($s) => $add($s->value, 'Pengaturan: '.$s->label));

        return $map;
    }
}
