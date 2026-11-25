<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesContentImages;
use App\Http\Controllers\Controller;
use App\Models\Concerns\HasManagedImage;
use App\Models\Umkm;
use App\Services\MediaService;
use App\Services\SiteContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UmkmController extends Controller
{
    use HandlesContentImages;

    public function index(): View
    {
        return view('admin.umkm.index', [
            'umkmList' => Umkm::ordered()->get(),
        ]);
    }

    public function create(MediaService $media): View
    {
        return view('admin.umkm.form', [
            'umkm' => new Umkm([
                'focal_point' => 'center center',
                'is_active' => true,
                'sort_order' => Umkm::max('sort_order') + 1,
            ]),
            'focalPoints' => HasManagedImage::allowedFocalPoints(),
            'mediaFiles' => $media->listManagedFiles(),
        ]);
    }

    public function store(Request $request, MediaService $media, SiteContentService $siteContent): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = Umkm::generateUniqueSlug($data['business_name']);

        $resolved = $this->resolveImageInput($request, $media, 'umkm', null, false);
        if ($resolved['should_update']) {
            $data['image_path'] = $resolved['path'];
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['updated_by'] = Auth::guard('admin')->id();

        Umkm::create($data);
        $siteContent->flushCache();

        return redirect()->route('admin.umkm.index')->with('status', 'Data UMKM lokal berhasil ditambahkan.');
    }

    public function edit(Umkm $umkm, MediaService $media): View
    {
        return view('admin.umkm.form', [
            'umkm' => $umkm,
            'focalPoints' => HasManagedImage::allowedFocalPoints(),
            'mediaFiles' => $media->listManagedFiles(),
        ]);
    }

    public function update(Request $request, Umkm $umkm, MediaService $media, SiteContentService $siteContent): RedirectResponse
    {
        $data = $this->validateData($request);
        if ($umkm->business_name !== $data['business_name']) {
            $data['slug'] = Umkm::generateUniqueSlug($data['business_name'], $umkm->id);
        }

        $resolved = $this->resolveImageInput($request, $media, 'umkm', $umkm->image_path);
        if ($resolved['should_update']) {
            $data['image_path'] = $resolved['path'];
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['updated_by'] = Auth::guard('admin')->id();

        $umkm->update($data);

        if ($resolved['should_update']) {
            $this->cleanupReplacedImage($media, $resolved['old_path'], $resolved['path']);
        }

        $siteContent->flushCache();

        return redirect()->route('admin.umkm.index')->with('status', 'Data UMKM berhasil diperbarui.');
    }

    public function destroy(Umkm $umkm, MediaService $media, SiteContentService $siteContent): RedirectResponse
    {
        $oldImage = $umkm->image_path;
        $umkm->delete();
        $media->deleteIfUnused($oldImage);
        $siteContent->flushCache();

        return redirect()->route('admin.umkm.index')->with('status', 'Data UMKM berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateData(Request $request): array
    {
        return $request->validate([
            'business_name' => ['required', 'string', 'max:160'],
            'product_type' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:5000'],
            'contact_info' => ['nullable', 'string', 'max:160'],
            'location_note' => ['nullable', 'string', 'max:180'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:'.config('admin.max_upload_kb', 5120)],
            'existing_image' => ['nullable', 'string', 'max:255'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'focal_point' => ['required', Rule::in(HasManagedImage::allowedFocalPoints())],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }
}
