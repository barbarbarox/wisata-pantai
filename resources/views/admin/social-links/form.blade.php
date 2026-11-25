@extends('layouts.admin')

@section('title', $socialLink->exists ? 'Edit Media Sosial' : 'Tambah Media Sosial')
@section('page-title', $socialLink->exists ? 'Edit Tautan Media Sosial' : 'Tambah Tautan Media Sosial')

@section('content')
    <div class="mb-5">
        <a href="{{ route('admin.social-links.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-charcoal-soft hover:text-ocean dark:text-white/70">
            <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
            <span>Kembali ke Media Sosial</span>
        </a>
    </div>

    <form
        method="POST"
        action="{{ $socialLink->exists ? route('admin.social-links.update', $socialLink) : route('admin.social-links.store') }}"
        class="space-y-6 border coastal-hairline bg-warm-white p-6 dark:bg-[#141f24] sm:p-8"
    >
        @csrf
        @if($socialLink->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Nama Platform</label>
                <input type="text" name="platform" value="{{ old('platform', $socialLink->platform) }}" placeholder="Misal: Instagram" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Label Tampilan</label>
                <input type="text" name="label" value="{{ old('label', $socialLink->label) }}" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="sm:col-span-2">
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">URL Lengkap (https://...)</label>
                <input type="url" name="url" value="{{ old('url', $socialLink->url) }}" placeholder="https://instagram.com/..." required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Ikon</label>
                <select name="icon" class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
                    @foreach(['instagram', 'facebook', 'youtube', 'globe', 'share-2'] as $ico)
                        <option value="{{ $ico }}" @selected(old('icon', $socialLink->icon) === $ico)>{{ $ico }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Urutan</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $socialLink->sort_order ?? 1) }}" min="0" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <label class="flex cursor-pointer items-center gap-2.5 self-end border coastal-hairline bg-[#f8f5ef] px-4 py-2.5 text-sm dark:bg-[#162126]">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $socialLink->is_active)) class="h-4 w-4 accent-ocean dark:accent-turquoise-bright">
                <span>Aktifkan di footer website</span>
            </label>
        </div>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.social-links.index') }}" class="rounded-[2px] border coastal-hairline px-5 py-2.5 text-xs font-semibold hover:bg-sand dark:hover:bg-white/10">Batal</a>
            <button type="submit" class="rounded-[2px] bg-ocean px-6 py-2.5 text-xs font-semibold text-warm-white hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal">
                Simpan Tautan
            </button>
        </div>
    </form>
@endsection

