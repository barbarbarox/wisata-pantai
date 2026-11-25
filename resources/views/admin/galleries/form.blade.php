@extends('layouts.admin')

@section('title', $gallery->exists ? 'Edit Foto Galeri' : 'Tambah Foto Galeri')
@section('page-title', $gallery->exists ? 'Edit Foto Galeri' : 'Tambah Foto Galeri')

@section('content')
    <div class="mb-5">
        <a href="{{ route('admin.galleries.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-charcoal-soft hover:text-ocean dark:text-white/70">
            <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
            <span>Kembali ke Galeri</span>
        </a>
    </div>

    <form
        method="POST"
        action="{{ $gallery->exists ? route('admin.galleries.update', $gallery) : route('admin.galleries.store') }}"
        enctype="multipart/form-data"
        class="space-y-6 border coastal-hairline bg-warm-white p-6 dark:bg-[#141f24] sm:p-8"
    >
        @csrf
        @if($gallery->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Judul Foto</label>
                <input type="text" name="title" value="{{ old('title', $gallery->title) }}" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Kategori</label>
                <input type="text" name="category" value="{{ old('category', $gallery->category ?: 'Pantai') }}" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
        </div>

        <div>
            <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Keterangan Foto (Caption)</label>
            <textarea name="caption" rows="2" class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">{{ old('caption', $gallery->caption) }}</textarea>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Rasio Grid Editorial</label>
                <select name="aspect_ratio" class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
                    @foreach($aspectRatios as $ratio)
                        <option value="{{ $ratio }}" @selected(old('aspect_ratio', $gallery->aspect_ratio) === $ratio)>{{ ucfirst($ratio) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Urutan Tampil</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $gallery->sort_order ?? 1) }}" min="0" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
        </div>

        <x-admin.image-field
            id="gallery-image-field"
            label="Berkas Foto Galeri"
            :currentPath="$gallery->image_path"
            :allowRemove="false"
            :mediaFiles="$mediaFiles"
            :focalPoints="$focalPoints"
            :focalPointValue="$gallery->focal_point ?? 'center center'"
            :altValue="$gallery->image_alt ?? ''"
        />

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <label class="flex cursor-pointer items-center gap-2.5 border coastal-hairline bg-[#f8f5ef] px-4 py-3 text-sm dark:bg-[#162126]">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $gallery->is_active)) class="h-4 w-4 accent-ocean dark:accent-turquoise-bright">
                <span>Tampilkan di galeri publik</span>
            </label>
            <label class="flex cursor-pointer items-center gap-2.5 border coastal-hairline bg-[#f8f5ef] px-4 py-3 text-sm dark:bg-[#162126]">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $gallery->is_featured)) class="h-4 w-4 accent-ocean dark:accent-turquoise-bright">
                <span>Tandai sebagai gambar unggulan</span>
            </label>
        </div>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.galleries.index') }}" class="rounded-[2px] border coastal-hairline px-5 py-2.5 text-xs font-semibold hover:bg-sand dark:hover:bg-white/10">Batal</a>
            <button type="submit" class="rounded-[2px] bg-ocean px-6 py-2.5 text-xs font-semibold text-warm-white hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal">
                Simpan Foto
            </button>
        </div>
    </form>
@endsection

