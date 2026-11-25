@extends('layouts.admin')

@section('title', $activity->exists ? 'Edit Aktivitas' : 'Tambah Aktivitas')
@section('page-title', $activity->exists ? 'Edit Aktivitas Wisata' : 'Tambah Aktivitas Wisata')

@section('content')
    <div class="mb-5">
        <a href="{{ route('admin.activities.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-charcoal-soft hover:text-ocean dark:text-white/70">
            <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
            <span>Kembali ke Aktivitas</span>
        </a>
    </div>

    <form
        method="POST"
        action="{{ $activity->exists ? route('admin.activities.update', $activity) : route('admin.activities.store') }}"
        enctype="multipart/form-data"
        class="space-y-6 border coastal-hairline bg-warm-white p-6 dark:bg-[#141f24] sm:p-8"
    >
        @csrf
        @if($activity->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Judul Aktivitas</label>
                <input type="text" name="title" value="{{ old('title', $activity->title) }}" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Kategori</label>
                <input type="text" name="category" value="{{ old('category', $activity->category) }}" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
        </div>

        <div>
            <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Ringkasan Singkat</label>
            <textarea name="summary" rows="2" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">{{ old('summary', $activity->summary) }}</textarea>
        </div>

        <div>
            <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Deskripsi Aktivitas</label>
            <textarea name="description" rows="4" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">{{ old('description', $activity->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Waktu Terbaik (Opsional)</label>
                <input type="text" name="best_time" value="{{ old('best_time', $activity->best_time) }}" placeholder="Misal: Pagi dan sore hari" class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Urutan</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $activity->sort_order ?? 1) }}" min="0" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
        </div>

        <x-admin.image-field
            id="activity-image-field"
            label="Foto Aktivitas"
            :currentPath="$activity->image_path"
            :allowRemove="$activity->exists"
            :mediaFiles="$mediaFiles"
            :focalPoints="$focalPoints"
            :focalPointValue="$activity->focal_point ?? 'center center'"
            :altValue="$activity->image_alt ?? ''"
        />

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <label class="flex cursor-pointer items-center gap-2.5 border coastal-hairline bg-[#f8f5ef] px-4 py-3 text-sm dark:bg-[#162126]">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $activity->is_active)) class="h-4 w-4 accent-ocean dark:accent-turquoise-bright">
                <span>Aktifkan di halaman publik</span>
            </label>
            <label class="flex cursor-pointer items-center gap-2.5 border coastal-hairline bg-[#f8f5ef] px-4 py-3 text-sm dark:bg-[#162126]">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $activity->is_featured)) class="h-4 w-4 accent-ocean dark:accent-turquoise-bright">
                <span>Tandai unggulan</span>
            </label>
        </div>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.activities.index') }}" class="rounded-[2px] border coastal-hairline px-5 py-2.5 text-xs font-semibold hover:bg-sand dark:hover:bg-white/10">Batal</a>
            <button type="submit" class="rounded-[2px] bg-ocean px-6 py-2.5 text-xs font-semibold text-warm-white hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal">
                Simpan Aktivitas
            </button>
        </div>
    </form>
@endsection

