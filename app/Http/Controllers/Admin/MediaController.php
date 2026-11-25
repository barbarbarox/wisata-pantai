<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function index(MediaService $media): View
    {
        return view('admin.media.index', [
            'files' => $media->listManagedFiles(),
        ]);
    }

    public function store(Request $request, MediaService $media): RedirectResponse
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:'.config('admin.max_upload_kb', 5120)],
            'folder' => ['nullable', 'in:uploads,heroes,spots,activities,umkm,gallery,settings'],
        ]);

        $folder = $validated['folder'] ?? 'uploads';
        $media->upload($request->file('image'), $folder);

        return redirect()->route('admin.media.index')->with('status', 'Gambar berhasil diunggah ke pustaka media.');
    }

    public function destroy(Request $request, MediaService $media): RedirectResponse
    {
        $validated = $request->validate([
            'path' => ['required', 'string', 'max:255'],
        ]);

        $path = $validated['path'];

        if (! $media->isManagedPath($path)) {
            return redirect()->route('admin.media.index')->with('error', 'File tidak ditemukan atau berada di luar direktori media yang dikelola aplikasi.');
        }

        if ($media->isPathReferenced($path)) {
            return redirect()->route('admin.media.index')->with('error', 'Gambar sedang digunakan pada konten website. Ganti gambar pada konten terkait sebelum menghapus.');
        }

        $media->forceDeleteManaged($path);

        return redirect()->route('admin.media.index')->with('status', 'File gambar yang tidak terpakai berhasil dihapus dari storage.');
    }
}
