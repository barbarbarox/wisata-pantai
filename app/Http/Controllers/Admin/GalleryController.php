<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesContentImages;
use App\Http\Controllers\Controller;
use App\Models\Concerns\HasManagedImage;
use App\Models\Gallery;
use App\Services\MediaService;
use App\Services\SiteContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GalleryController extends Controller
{
    use HandlesContentImages;

    public function index(): View
    {
        return view('admin.galleries.index', [
            'galleries' => Gallery::ordered()->get(),
        ]);
    }

    public function create(MediaService $media): View
    {
        return view('admin.galleries.form', [
            'gallery' => new Gallery([
                'focal_point' => 'center center',
                'aspect_ratio' => 'landscape',
                'category' => 'Pantai',
                'is_active' => true,
                'sort_order' => Gallery::max('sort_order') + 1,
            ]),
            'focalPoints' => HasManagedImage::allowedFocalPoints(),
            'aspectRatios' => Gallery::allowedAspectRatios(),
            'mediaFiles' => $media->listManagedFiles(),
        ]);
    }

    public function store(Request $request, MediaService $media, SiteContentService $siteContent): RedirectResponse
    {
        $data = $this->validateData($request, requireImage: true);
        $resolved = $this->resolveImageInput($request, $media, 'gallery', null, false);

        if (! $resolved['should_update'] || ! $resolved['path']) {
            return back()->withErrors(['image' => 'Silakan unggah foto baru atau pilih foto dari pustaka media.'])->withInput();
        }

        $data['image_path'] = $resolved['path'];
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['updated_by'] = Auth::guard('admin')->id();

        Gallery::create($data);
        $siteContent->flushCache();

        return redirect()->route('admin.galleries.index')->with('status', 'Foto galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery, MediaService $media): View
    {
        return view('admin.galleries.form', [
            'gallery' => $gallery,
            'focalPoints' => HasManagedImage::allowedFocalPoints(),
            'aspectRatios' => Gallery::allowedAspectRatios(),
            'mediaFiles' => $media->listManagedFiles(),
        ]);
    }

    public function update(Request $request, Gallery $gallery, MediaService $media, SiteContentService $siteContent): RedirectResponse
    {
        $data = $this->validateData($request, requireImage: false);
        $resolved = $this->resolveImageInput($request, $media, 'gallery', $gallery->image_path, false);

        if ($resolved['should_update'] && $resolved['path']) {
            $data['image_path'] = $resolved['path'];
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['updated_by'] = Auth::guard('admin')->id();

        $gallery->update($data);

        if ($resolved['should_update']) {
            $this->cleanupReplacedImage($media, $resolved['old_path'], $resolved['path']);
        }

        $siteContent->flushCache();

        return redirect()->route('admin.galleries.index')->with('status', 'Item galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery, MediaService $media, SiteContentService $siteContent): RedirectResponse
    {
        $oldImage = $gallery->image_path;
        $gallery->delete();
        $media->deleteIfUnused($oldImage);
        $siteContent->flushCache();

        return redirect()->route('admin.galleries.index')->with('status', 'Foto galeri berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateData(Request $request, bool $requireImage): array
    {
        $imageRules = ['image', 'mimes:jpg,jpeg,png,webp', 'max:'.config('admin.max_upload_kb', 5120)];
        if ($requireImage && ! $request->filled('existing_image')) {
            array_unshift($imageRules, 'required');
        } else {
            array_unshift($imageRules, 'nullable');
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'caption' => ['nullable', 'string', 'max:1000'],
            'category' => ['required', 'string', 'max:80'],
            'image' => $imageRules,
            'existing_image' => ['nullable', 'string', 'max:255'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'focal_point' => ['required', Rule::in(HasManagedImage::allowedFocalPoints())],
            'aspect_ratio' => ['required', Rule::in(Gallery::allowedAspectRatios())],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }
}
