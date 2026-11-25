<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Services\MediaService;
use App\Services\SiteContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(MediaService $media): View
    {
        $settings = SiteSetting::orderBy('id')->get()->groupBy('group');

        return view('admin.settings.edit', [
            'groupedSettings' => $settings,
            'mediaFiles' => $media->listManagedFiles(),
        ]);
    }

    public function update(Request $request, MediaService $media, SiteContentService $siteContent): RedirectResponse
    {
        $allSettings = SiteSetting::all()->keyBy('key');
        $adminId = Auth::guard('admin')->id();

        $rules = [];
        foreach ($allSettings as $key => $setting) {
            if ($setting->type === 'image') {
                $rules['files.'.$key] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:'.config('admin.max_upload_kb', 5120)];
                $rules['existing_media.'.$key] = ['nullable', 'string', 'max:255'];
            } elseif ($setting->type === 'boolean') {
                $rules['settings.'.$key] = ['nullable', 'in:0,1'];
            } elseif (str_contains($key, 'latitude') || str_contains($key, 'longitude')) {
                $rules['settings.'.$key] = ['nullable', 'numeric', 'between:-180,180'];
            } else {
                $rules['settings.'.$key] = ['nullable', 'string', 'max:5000'];
            }
        }

        $validated = $request->validate($rules);

        foreach ($allSettings as $key => $setting) {
            if ($setting->type === 'image') {
                if ($request->boolean('remove_files.'.$key)) {
                    $oldPath = $setting->value;
                    $setting->update(['value' => null, 'updated_by' => $adminId]);
                    $media->deleteIfUnused($oldPath);
                    continue;
                }

                $uploaded = $request->file('files.'.$key);
                if ($uploaded) {
                    $oldPath = $setting->value;
                    $newPath = $media->upload($uploaded, 'settings');
                    $setting->update(['value' => $newPath, 'updated_by' => $adminId]);
                    $media->deleteIfUnused($oldPath);
                    continue;
                }

                $existingPath = $validated['existing_media'][$key] ?? null;
                if ($existingPath && $media->isManagedPath($existingPath) && $existingPath !== $setting->value) {
                    $oldPath = $setting->value;
                    $setting->update(['value' => $existingPath, 'updated_by' => $adminId]);
                    $media->deleteIfUnused($oldPath);
                }

                continue;
            }

            if ($setting->type === 'boolean') {
                $boolVal = $request->input('settings.'.$key) === '1' ? '1' : '0';
                $setting->update(['value' => $boolVal, 'updated_by' => $adminId]);
                continue;
            }

            if (array_key_exists($key, $validated['settings'] ?? [])) {
                $setting->update([
                    'value' => $validated['settings'][$key],
                    'updated_by' => $adminId,
                ]);
            }
        }

        $siteContent->flushCache();

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Pengaturan website dan konfigurasi bagian berhasil diperbarui.');
    }
}
