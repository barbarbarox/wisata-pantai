@extends('layouts.admin')

@section('title', $hero->exists ? 'Edit Hero' : 'Tambah Hero')
@section('page-title', $hero->exists ? 'Edit Hero Section' : 'Tambah Variasi Hero')

@section('content')
    <div class="mb-5">
        <a href="{{ route('admin.heroes.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-charcoal-soft hover:text-ocean dark:text-white/70">
            <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
            <span>Kembali ke Daftar Hero</span>
        </a>
    </div>

    <form
        method="POST"
        action="{{ $hero->exists ? route('admin.heroes.update', $hero) : route('admin.heroes.store') }}"
        enctype="multipart/form-data"
        class="space-y-6 border coastal-hairline bg-warm-white p-6 dark:bg-[#141f24] sm:p-8"
    >
        @csrf
        @if($hero->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Eyebrow Text</label>
                <input type="text" name="eyebrow" value="{{ old('eyebrow', $hero->eyebrow ?: 'DESTINASI WISATA BENGKALIS') }}" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Urutan</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $hero->sort_order ?? 1) }}" min="0" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
        </div>

        <div>
            <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Heading Utama</label>
            <input type="text" name="title" value="{{ old('title', $hero->title) }}" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
        </div>

        <div>
            <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Deskripsi Singkat</label>
            <textarea name="subtitle" rows="3" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">{{ old('subtitle', $hero->subtitle) }}</textarea>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Teks CTA Utama</label>
                <input type="text" name="primary_cta_text" value="{{ old('primary_cta_text', $hero->primary_cta_text ?: 'Jelajahi Pantai') }}" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">URL CTA Utama</label>
                <input type="text" name="primary_cta_url" value="{{ old('primary_cta_url', $hero->primary_cta_url ?: '#destinasi') }}" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Teks CTA Sekunder</label>
                <input type="text" name="secondary_cta_text" value="{{ old('secondary_cta_text', $hero->secondary_cta_text ?: 'Lihat Galeri') }}" class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">URL CTA Sekunder</label>
                <input type="text" name="secondary_cta_url" value="{{ old('secondary_cta_url', $hero->secondary_cta_url ?: '#galeri') }}" class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
        </div>

        <x-admin.image-field
            id="hero-bg-field"
            label="Background Foto Hero"
            :currentPath="$hero->background_image"
            :allowRemove="$hero->exists"
            :mediaFiles="$mediaFiles"
            :focalPoints="$focalPoints"
            :focalPointValue="$hero->focal_point ?? 'center center'"
            :altValue="$hero->image_alt ?? ''"
        />

        <label class="flex cursor-pointer items-center gap-2.5 border coastal-hairline bg-[#f8f5ef] px-4 py-3 text-sm dark:bg-[#162126]">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $hero->is_active)) class="h-4 w-4 accent-ocean dark:accent-turquoise-bright">
            <span>Aktifkan variasi hero ini di halaman utama</span>
        </label>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.heroes.index') }}" class="rounded-[2px] border coastal-hairline px-5 py-2.5 text-xs font-semibold hover:bg-sand dark:hover:bg-white/10">Batal</a>
            <button type="submit" class="rounded-[2px] bg-ocean px-6 py-2.5 text-xs font-semibold text-warm-white hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal">
                Simpan Hero
            </button>
        </div>
    </form>
@endsection

