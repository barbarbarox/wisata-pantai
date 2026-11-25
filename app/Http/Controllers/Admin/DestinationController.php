<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concerns\HasManagedImage;
use App\Models\Destination;
use App\Services\MediaService;
use App\Services\SiteContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DestinationController extends Controller
{
    public function index(): View
    {
        return view('admin.destinations.index', [
            'destinations' => Destination::ordered()->get(),
        ]);
    }

    public function create(MediaService $media): View
    {
        return view('admin.destinations.form', [
            'destination' => new Destination([
                'focal_point' => 'center center',
                'is_active' => true,
                'sort_order' => Destination::max('sort_order') + 1,
            ]),
            'focalPoints' => HasManagedImage::allowedFocalPoints(),
            'mediaFiles' => $media->listManagedFiles(),
        ]);
    }

    public function store(Request $request, MediaService $media, SiteContentService $siteContent): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = Destination::generateUniqueSlug($data['name']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $media->upload($request->file('image'), 'spots');
        } elseif ($request->filled('existing_image') && $media->isManagedPath($request->input('existing_image'))) {
            $data['image_path'] = $request->input('existing_image');
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['updated_by'] = Auth::guard('admin')->id();

        Destination::create($data);
        $siteContent->flushCache();

        return redirect()->route('admin.destinations.index')->with('status', 'Spot wisata baru berhasil ditambahkan.');
    }

    public function edit(Destination $destination, MediaService $media): View
    {
        return view('admin.destinations.form', [
            'destination' => $destination,
            'focalPoints' => HasManagedImage::allowedFocalPoints(),
            'mediaFiles' => $media->listManagedFiles(),
        ]);
    }

    public function update(Request $request, Destination $destination, MediaService $media, SiteContentService $siteContent): RedirectResponse
    {
        $data = $this->validateData($request);
        if ($destination->name !== $data['name']) {
            $data['slug'] = Destination::generateUniqueSlug($data['name'], $destination->id);
        }

        $oldImage = $destination->image_path;

        if ($request->boolean('remove_image')) {
            $data['image_path'] = null;
        } elseif ($request->hasFile('image')) {
            $data['image_path'] = $media->upload($request->file('image'), 'spots');
        } elseif ($request->filled('existing_image') && $media->isManagedPath($request->input('existing_image'))) {
            $data['image_path'] = $request->input('existing_image');
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['updated_by'] = Auth::guard('admin')->id();

        $destination->update($data);

        if (array_key_exists('image_path', $data) && $oldImage && $oldImage !== $data['image_path']) {
            $media->deleteIfUnused($oldImage);
        }

        $siteContent->flushCache();

        return redirect()->route('admin.destinations.index')->with('status', 'Data spot wisata berhasil diperbarui.');
    }

    public function destroy(Destination $destination, MediaService $media, SiteContentService $siteContent): RedirectResponse
    {
        $oldImage = $destination->image_path;
        $destination->delete();
        $media->deleteIfUnused($oldImage);
        $siteContent->flushCache();

        return redirect()->route('admin.destinations.index')->with('status', 'Spot wisata berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'category' => ['required', 'string', 'max:80'],
            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string', 'max:5000'],
            'additional_info' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:'.config('admin.max_upload_kb', 5120)],
            'existing_image' => ['nullable', 'string', 'max:255'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'focal_point' => ['required', Rule::in(HasManagedImage::allowedFocalPoints())],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }
}
