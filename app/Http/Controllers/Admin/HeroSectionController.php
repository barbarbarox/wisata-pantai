<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Concerns\HasManagedImage;
use App\Models\HeroSection;
use App\Services\MediaService;
use App\Services\SiteContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class HeroSectionController extends Controller
{
    public function index(): View
    {
        return view('admin.heroes.index', [
            'heroes' => HeroSection::ordered()->get(),
        ]);
    }

    public function create(MediaService $media): View
    {
        return view('admin.heroes.form', [
            'hero' => new HeroSection(['focal_point' => 'center center', 'sort_order' => HeroSection::max('sort_order') + 1]),
            'focalPoints' => HasManagedImage::allowedFocalPoints(),
            'mediaFiles' => $media->listManagedFiles(),
        ]);
    }

    public function store(Request $request, MediaService $media, SiteContentService $siteContent): RedirectResponse
    {
        $data = $this->validateHero($request);

        if ($request->hasFile('image')) {
            $data['background_image'] = $media->upload($request->file('image'), 'heroes');
        } elseif ($request->filled('existing_image') && $media->isManagedPath($request->input('existing_image'))) {
            $data['background_image'] = $request->input('existing_image');
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['updated_by'] = Auth::guard('admin')->id();

        if ($data['is_active']) {
            HeroSection::query()->update(['is_active' => false]);
        }

        HeroSection::create($data);
        $siteContent->flushCache();

        return redirect()->route('admin.heroes.index')->with('status', 'Variasi hero baru berhasil ditambahkan.');
    }

    public function edit(HeroSection $hero, MediaService $media): View
    {
        return view('admin.heroes.form', [
            'hero' => $hero,
            'focalPoints' => HasManagedImage::allowedFocalPoints(),
            'mediaFiles' => $media->listManagedFiles(),
        ]);
    }

    public function update(Request $request, HeroSection $hero, MediaService $media, SiteContentService $siteContent): RedirectResponse
    {
        $data = $this->validateHero($request);
        $oldImage = $hero->background_image;

        if ($request->boolean('remove_image')) {
            $data['background_image'] = null;
        } elseif ($request->hasFile('image')) {
            $data['background_image'] = $media->upload($request->file('image'), 'heroes');
        } elseif ($request->filled('existing_image') && $media->isManagedPath($request->input('existing_image'))) {
            $data['background_image'] = $request->input('existing_image');
        }

        $data['is_active'] = $request->boolean('is_active');
        $data['updated_by'] = Auth::guard('admin')->id();

        if ($data['is_active']) {
            HeroSection::where('id', '!=', $hero->id)->update(['is_active' => false]);
        }

        $hero->update($data);

        if (array_key_exists('background_image', $data) && $oldImage && $oldImage !== $data['background_image']) {
            $media->deleteIfUnused($oldImage);
        }

        $siteContent->flushCache();

        return redirect()->route('admin.heroes.index')->with('status', 'Bagian hero berhasil diperbarui.');
    }

    public function destroy(HeroSection $hero, MediaService $media, SiteContentService $siteContent): RedirectResponse
    {
        if (HeroSection::count() <= 1) {
            return redirect()->route('admin.heroes.index')->with('error', 'Minimal harus ada satu hero section yang tersisa.');
        }

        $oldImage = $hero->background_image;
        $wasActive = $hero->is_active;
        $hero->delete();
        $media->deleteIfUnused($oldImage);

        if ($wasActive) {
            $first = HeroSection::ordered()->first();
            $first?->update(['is_active' => true]);
        }

        $siteContent->flushCache();

        return redirect()->route('admin.heroes.index')->with('status', 'Variasi hero berhasil dihapus.');
    }

    public function activate(HeroSection $hero, SiteContentService $siteContent): RedirectResponse
    {
        HeroSection::query()->update(['is_active' => false]);
        $hero->update([
            'is_active' => true,
            'updated_by' => Auth::guard('admin')->id(),
        ]);
        $siteContent->flushCache();

        return redirect()->route('admin.heroes.index')->with('status', 'Hero aktif berhasil diganti ke "'.$hero->title.'".');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateHero(Request $request): array
    {
        return $request->validate([
            'eyebrow' => ['required', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:180'],
            'subtitle' => ['required', 'string', 'max:1000'],
            'primary_cta_text' => ['required', 'string', 'max:80'],
            'primary_cta_url' => ['required', 'string', 'max:255', 'regex:/^(https?:\/\/|\/|#)/i'],
            'secondary_cta_text' => ['nullable', 'string', 'max:80'],
            'secondary_cta_url' => ['nullable', 'string', 'max:255', 'regex:/^(https?:\/\/|\/|#)/i'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:'.config('admin.max_upload_kb', 5120)],
            'existing_image' => ['nullable', 'string', 'max:255'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'focal_point' => ['required', Rule::in(HasManagedImage::allowedFocalPoints())],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }
}
