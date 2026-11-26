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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

class MediaService
{
    public const ROOT_DIR = 'media';

    public function upload(UploadedFile $file, string $subdirectory = 'uploads', ?string $previousPath = null): string
    {
        $cleanSubdir = trim(preg_replace('/[^a-zA-Z0-9_-]/', '', $subdirectory) ?: 'uploads', '/');
        $extension = strtolower($file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'webp');
        $filename = Str::uuid()->toString().'.'.$extension;
        $objectPath = self::ROOT_DIR.'/'.$cleanSubdir.'/'.$filename;

        if ($this->usesSupabaseStorage()) {
            $storedUrl = $this->uploadToSupabase($file, $objectPath);

            if ($previousPath && $previousPath !== $storedUrl) {
                $this->deleteIfUnused($previousPath);
            }

            return $storedUrl;
        }

        if ($this->isReadOnlyServerless()) {
            throw ValidationException::withMessages([
                'image' => 'Filesystem Vercel bersifat read-only. Tambahkan SUPABASE_URL dan SUPABASE_SERVICE_KEY di Environment Variables Vercel untuk mengaktifkan upload gambar persisten.',
            ]);
        }

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
        if (! $path || $this->isPathReferenced($path)) {
            return false;
        }

        if ($this->isSupabasePublicUrl($path) && $this->usesSupabaseStorage()) {
            return $this->deleteFromSupabase($path);
        }

        if (! $this->isManagedLocalFile($path)) {
            return false;
        }

        return Storage::disk('public')->delete($path);
    }

    public function forceDeleteManaged(?string $path): bool
    {
        if (! $path) {
            return false;
        }

        if ($this->isSupabasePublicUrl($path) && $this->usesSupabaseStorage()) {
            return $this->deleteFromSupabase($path);
        }

        if (! $this->isManagedLocalFile($path)) {
            return false;
        }

        return Storage::disk('public')->delete($path);
    }

    public function isManagedPath(?string $path): bool
    {
        if (! $path || str_contains($path, '..') || str_contains($path, "\0")) {
            return false;
        }

        if ($this->isSupabasePublicUrl($path)) {
            return true;
        }

        $normalized = ltrim($path, '/');

        if (str_starts_with($normalized, 'seed-media/') && File::exists(public_path($normalized))) {
            return true;
        }

        return str_starts_with($normalized, self::ROOT_DIR.'/')
            && (Storage::disk('public')->exists($normalized) || File::exists(public_path('seed-media/'.basename($normalized))));
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
        $references = $this->collectReferenceMap();
        $files = [];
        $disk = Storage::disk('public');

        if ($disk->exists(self::ROOT_DIR)) {
            foreach ($disk->allFiles(self::ROOT_DIR) as $file) {
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (! in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                    continue;
                }

                $files[] = [
                    'path' => $file,
                    'url' => SiteSetting::imageUrlFor($file),
                    'name' => basename($file),
                    'folder' => dirname($file),
                    'size_kb' => round($disk->size($file) / 1024, 1),
                    'last_modified' => $disk->lastModified($file),
                    'used_in' => $references[$file] ?? [],
                ];
            }
        }

        if (empty($files) && File::isDirectory(public_path('seed-media'))) {
            foreach (File::files(public_path('seed-media')) as $file) {
                $name = $file->getFilename();
                $folder = str_starts_with($name, 'hero-') ? 'heroes' : 'spots';
                $logicalPath = self::ROOT_DIR.'/'.$folder.'/'.$name;
                $files[] = [
                    'path' => $logicalPath,
                    'url' => '/seed-media/'.$name,
                    'name' => $name,
                    'folder' => 'seed-media',
                    'size_kb' => round($file->getSize() / 1024, 1),
                    'last_modified' => $file->getMTime(),
                    'used_in' => $references[$logicalPath] ?? [],
                ];
            }
        }

        usort($files, fn (array $a, array $b) => $b['last_modified'] <=> $a['last_modified']);

        return $files;
    }

    private function isManagedLocalFile(?string $path): bool
    {
        if (! $path || str_contains($path, '..') || str_contains($path, "\0")) {
            return false;
        }

        $normalized = ltrim($path, '/');

        return str_starts_with($normalized, self::ROOT_DIR.'/')
            && Storage::disk('public')->exists($normalized);
    }

    private function usesSupabaseStorage(): bool
    {
        return ! empty(config('services.supabase.url')) && ! empty(config('services.supabase.service_key'));
    }

    private function isReadOnlyServerless(): bool
    {
        return isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || (bool) getenv('VERCEL');
    }

    private function isSupabasePublicUrl(string $path): bool
    {
        $baseUrl = rtrim((string) config('services.supabase.url'), '/');

        return $baseUrl !== '' && str_starts_with($path, $baseUrl.'/storage/v1/object/public/');
    }

    private function uploadToSupabase(UploadedFile $file, string $objectPath): string
    {
        $baseUrl = rtrim((string) config('services.supabase.url'), '/');
        $serviceKey = (string) config('services.supabase.service_key');
        $bucket = (string) config('services.supabase.bucket', 'coastal-media');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$serviceKey,
            'apikey' => $serviceKey,
            'Content-Type' => $file->getMimeType() ?: 'image/webp',
            'x-upsert' => 'true',
        ])->withBody(
            File::get($file->getRealPath()),
            $file->getMimeType() ?: 'image/webp'
        )->post("{$baseUrl}/storage/v1/object/{$bucket}/{$objectPath}");

        if ($response->failed()) {
            throw ValidationException::withMessages([
                'image' => 'Gagal mengunggah gambar ke Supabase Storage: '.$response->status(),
            ]);
        }

        return "{$baseUrl}/storage/v1/object/public/{$bucket}/{$objectPath}";
    }

    private function deleteFromSupabase(string $publicUrl): bool
    {
        $baseUrl = rtrim((string) config('services.supabase.url'), '/');
        $serviceKey = (string) config('services.supabase.service_key');
        $bucket = (string) config('services.supabase.bucket', 'coastal-media');
        $prefix = "{$baseUrl}/storage/v1/object/public/{$bucket}/";

        if (! str_starts_with($publicUrl, $prefix)) {
            return false;
        }

        $objectPath = substr($publicUrl, strlen($prefix));

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$serviceKey,
            'apikey' => $serviceKey,
        ])->delete("{$baseUrl}/storage/v1/object/{$bucket}/{$objectPath}");

        return $response->successful();
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
