@extends('layouts.admin')

@section('title', $destination->exists ? 'Edit Spot Wisata' : 'Tambah Spot Wisata')
@section('page-title', $destination->exists ? 'Edit Spot Wisata' : 'Tambah Spot Wisata')

@section('content')
    <div class="mb-5">
        <a href="{{ route('admin.destinations.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-charcoal-soft hover:text-ocean dark:text-white/70">
            <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
            <span>Kembali ke Spot Wisata</span>
        </a>
    </div>

    <form
        method="POST"
        action="{{ $destination->exists ? route('admin.destinations.update', $destination) : route('admin.destinations.store') }}"
        enctype="multipart/form-data"
        class="space-y-6 border coastal-hairline bg-warm-white p-6 dark:bg-[#141f24] sm:p-8"
    >
        @csrf
        @if($destination->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Nama Spot Wisata</label>
                <input type="text" name="name" value="{{ old('name', $destination->name) }}" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Kategori</label>
                <input type="text" name="category" value="{{ old('category', $destination->category) }}" placeholder="Misal: Garis Pantai" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
        </div>

        <div>
            <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Ringkasan Singkat</label>
            <textarea name="short_description" rows="2" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">{{ old('short_description', $destination->short_description) }}</textarea>
        </div>

        <div>
            <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Deskripsi Lengkap</label>
            <textarea name="description" rows="4" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">{{ old('description', $destination->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Informasi Tambahan (Opsional)</label>
                <input type="text" name="additional_info" value="{{ old('additional_info', $destination->additional_info) }}" class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Urutan Tampil</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $destination->sort_order ?? 1) }}" min="0" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
        </div>

        <x-admin.image-field
            id="spot-image-field"
            label="Foto Spot Wisata"
            :currentPath="$destination->image_path"
            :allowRemove="$destination->exists"
            :mediaFiles="$mediaFiles"
            :focalPoints="$focalPoints"
            :focalPointValue="$destination->focal_point ?? 'center center'"
            :altValue="$destination->image_alt ?? ''"
        />

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <label class="flex cursor-pointer items-center gap-2.5 border coastal-hairline bg-[#f8f5ef] px-4 py-3 text-sm dark:bg-[#162126]">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $destination->is_active)) class="h-4 w-4 accent-ocean dark:accent-turquoise-bright">
                <span>Tampilkan di halaman publik</span>
            </label>
            <label class="flex cursor-pointer items-center gap-2.5 border coastal-hairline bg-[#f8f5ef] px-4 py-3 text-sm dark:bg-[#162126]">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $destination->is_featured)) class="h-4 w-4 accent-ocean dark:accent-turquoise-bright">
                <span>Tandai sebagai spot unggulan</span>
            </label>
        </div>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.destinations.index') }}" class="rounded-[2px] border coastal-hairline px-5 py-2.5 text-xs font-semibold hover:bg-sand dark:hover:bg-white/10">Batal</a>
            <button type="submit" class="rounded-[2px] bg-ocean px-6 py-2.5 text-xs font-semibold text-warm-white hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal">
                Simpan Spot Wisata
            </button>
        </div>
    </form>
@endsection

