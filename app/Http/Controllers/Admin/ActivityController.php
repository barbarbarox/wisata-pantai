<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesContentImages;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Concerns\HasManagedImage;
use App\Services\MediaService;
use App\Services\SiteContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ActivityController extends Controller
{
    use HandlesContentImages;

    public function index(): View
    {
        return view('admin.activities.index', [
            'activities' => Activity::ordered()->get(),
        ]);
    }

    public function create(MediaService $media): View
    {
        return view('admin.activities.form', [
            'activity' => new Activity([
                'focal_point' => 'center center',
                'is_active' => true,
                'sort_order' => Activity::max('sort_order') + 1,
            ]),
            'focalPoints' => HasManagedImage::allowedFocalPoints(),
            'mediaFiles' => $media->listManagedFiles(),
        ]);
    }

    public function store(Request $request, MediaService $media, SiteContentService $siteContent): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = Activity::generateUniqueSlug($data['title']);

        $resolved = $this->resolveImageInput($request, $media, 'activities', null, false);
        if ($resolved['should_update']) {
            $data['image_path'] = $resolved['path'];
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['updated_by'] = Auth::guard('admin')->id();

        Activity::create($data);
        $siteContent->flushCache();

        return redirect()->route('admin.activities.index')->with('status', 'Aktivitas wisata baru berhasil ditambahkan.');
    }

    public function edit(Activity $activity, MediaService $media): View
    {
        return view('admin.activities.form', [
            'activity' => $activity,
            'focalPoints' => HasManagedImage::allowedFocalPoints(),
            'mediaFiles' => $media->listManagedFiles(),
        ]);
    }

    public function update(Request $request, Activity $activity, MediaService $media, SiteContentService $siteContent): RedirectResponse
    {
        $data = $this->validateData($request);
        if ($activity->title !== $data['title']) {
            $data['slug'] = Activity::generateUniqueSlug($data['title'], $activity->id);
        }

        $resolved = $this->resolveImageInput($request, $media, 'activities', $activity->image_path);
        if ($resolved['should_update']) {
            $data['image_path'] = $resolved['path'];
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');
        $data['updated_by'] = Auth::guard('admin')->id();

        $activity->update($data);

        if ($resolved['should_update']) {
            $this->cleanupReplacedImage($media, $resolved['old_path'], $resolved['path']);
        }

        $siteContent->flushCache();

        return redirect()->route('admin.activities.index')->with('status', 'Data aktivitas wisata berhasil diperbarui.');
    }

    public function destroy(Activity $activity, MediaService $media, SiteContentService $siteContent): RedirectResponse
    {
        $oldImage = $activity->image_path;
        $activity->delete();
        $media->deleteIfUnused($oldImage);
        $siteContent->flushCache();

        return redirect()->route('admin.activities.index')->with('status', 'Aktivitas wisata berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'category' => ['required', 'string', 'max:80'],
            'summary' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string', 'max:5000'],
            'best_time' => ['nullable', 'string', 'max:120'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:'.config('admin.max_upload_kb', 5120)],
            'existing_image' => ['nullable', 'string', 'max:255'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'focal_point' => ['required', Rule::in(HasManagedImage::allowedFocalPoints())],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }
}
