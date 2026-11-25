@extends('layouts.admin')

@section('title', $umkm->exists ? 'Edit UMKM' : 'Tambah UMKM')
@section('page-title', $umkm->exists ? 'Edit Data UMKM' : 'Tambah Data UMKM')

@section('content')
    <div class="mb-5">
        <a href="{{ route('admin.umkm.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-charcoal-soft hover:text-ocean dark:text-white/70">
            <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
            <span>Kembali ke Daftar UMKM</span>
        </a>
    </div>

    <form
        method="POST"
        action="{{ $umkm->exists ? route('admin.umkm.update', $umkm) : route('admin.umkm.store') }}"
        enctype="multipart/form-data"
        class="space-y-6 border coastal-hairline bg-warm-white p-6 dark:bg-[#141f24] sm:p-8"
    >
        @csrf
        @if($umkm->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Nama Usaha / UMKM</label>
                <input type="text" name="business_name" value="{{ old('business_name', $umkm->business_name) }}" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Jenis Produk</label>
                <input type="text" name="product_type" value="{{ old('product_type', $umkm->product_type) }}" placeholder="Misal: Kuliner Khas Pesisir" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
        </div>

        <div>
            <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Deskripsi Usaha &amp; Produk</label>
            <textarea name="description" rows="4" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">{{ old('description', $umkm->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Informasi Kontak (Opsional)</label>
                <input type="text" name="contact_info" value="{{ old('contact_info', $umkm->contact_info) }}" placeholder="Nomor WhatsApp atau kontak resmi" class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Catatan Lokasi (Opsional)</label>
                <input type="text" name="location_note" value="{{ old('location_note', $umkm->location_note) }}" class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Urutan</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $umkm->sort_order ?? 1) }}" min="0" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
        </div>

        <x-admin.image-field
            id="umkm-image-field"
            label="Foto Usaha / Produk UMKM (Opsional)"
            :currentPath="$umkm->image_path"
            :allowRemove="$umkm->exists"
            :mediaFiles="$mediaFiles"
            :focalPoints="$focalPoints"
            :focalPointValue="$umkm->focal_point ?? 'center center'"
            :altValue="$umkm->image_alt ?? ''"
        />

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <label class="flex cursor-pointer items-center gap-2.5 border coastal-hairline bg-[#f8f5ef] px-4 py-3 text-sm dark:bg-[#162126]">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $umkm->is_active)) class="h-4 w-4 accent-ocean dark:accent-turquoise-bright">
                <span>Tampilkan di halaman publik</span>
            </label>
            <label class="flex cursor-pointer items-center gap-2.5 border coastal-hairline bg-[#f8f5ef] px-4 py-3 text-sm dark:bg-[#162126]">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $umkm->is_featured)) class="h-4 w-4 accent-ocean dark:accent-turquoise-bright">
                <span>Tandai sebagai unggulan</span>
            </label>
        </div>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.umkm.index') }}" class="rounded-[2px] border coastal-hairline px-5 py-2.5 text-xs font-semibold hover:bg-sand dark:hover:bg-white/10">Batal</a>
            <button type="submit" class="rounded-[2px] bg-ocean px-6 py-2.5 text-xs font-semibold text-warm-white hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal">
                Simpan UMKM
            </button>
        </div>
    </form>
@endsection

