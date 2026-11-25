@extends('layouts.admin')

@section('title', $contact->exists ? 'Edit Kontak' : 'Tambah Kontak')
@section('page-title', $contact->exists ? 'Edit Informasi Kontak' : 'Tambah Informasi Kontak')

@section('content')
    <div class="mb-5">
        <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-charcoal-soft hover:text-ocean dark:text-white/70">
            <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
            <span>Kembali ke Daftar Kontak</span>
        </a>
    </div>

    <form
        method="POST"
        action="{{ $contact->exists ? route('admin.contacts.update', $contact) : route('admin.contacts.store') }}"
        class="space-y-6 border coastal-hairline bg-warm-white p-6 dark:bg-[#141f24] sm:p-8"
    >
        @csrf
        @if($contact->exists)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Label Kontak</label>
                <input type="text" name="label" value="{{ old('label', $contact->label) }}" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Tipe</label>
                <select name="type" class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
                    @foreach(['address' => 'Alamat', 'phone' => 'Telepon', 'email' => 'Email', 'hours' => 'Jam Layanan', 'info' => 'Informasi Umum'] as $val => $txt)
                        <option value="{{ $val }}" @selected(old('type', $contact->type) === $val)>{{ $txt }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Ikon</label>
                <select name="icon" class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
                    @foreach(['map-pin', 'phone', 'mail', 'clock', 'compass', 'info'] as $ico)
                        <option value="{{ $ico }}" @selected(old('icon', $contact->icon) === $ico)>{{ $ico }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Isi Kontak / Keterangan</label>
            <textarea name="value" rows="3" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">{{ old('value', $contact->value) }}</textarea>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Urutan</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $contact->sort_order ?? 1) }}" min="0" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <label class="flex cursor-pointer items-center gap-2.5 self-end border coastal-hairline bg-[#f8f5ef] px-4 py-2.5 text-sm dark:bg-[#162126]">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $contact->is_active)) class="h-4 w-4 accent-ocean dark:accent-turquoise-bright">
                <span>Tampilkan di halaman publik</span>
            </label>
        </div>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.contacts.index') }}" class="rounded-[2px] border coastal-hairline px-5 py-2.5 text-xs font-semibold hover:bg-sand dark:hover:bg-white/10">Batal</a>
            <button type="submit" class="rounded-[2px] bg-ocean px-6 py-2.5 text-xs font-semibold text-warm-white hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal">
                Simpan Kontak
            </button>
        </div>
    </form>
@endsection

