@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('page-title', 'Pengaturan Website & Bagian Halaman')

@section('content')
    @php
        $groupTitles = [
            'general' => ['title' => 'Identitas Utama & SEO', 'desc' => 'Nama website, slogan wilayah, deskripsi meta, dan logo opsional.'],
            'about' => ['title' => 'Bagian Tentang Pantai (Pengantar)', 'desc' => 'Konten editorial pengantar Pantai Selat Baru beserta foto utama dan pendamping.'],
            'sections' => ['title' => 'Kontrol & Judul Bagian Halaman', 'desc' => 'Aktifkan atau nonaktifkan bagian publik serta ubah judul dan subjudul setiap section.'],
            'backgrounds' => ['title' => 'Background Website & Banner Editorial', 'desc' => 'Atur latar belakang halaman, banner jeda editorial, dan latar footer.'],
            'location' => ['title' => 'Peta OpenStreetMap & Lokasi', 'desc' => 'Koordinat lintang/bujur untuk pin peta dan catatan akses pengunjung.'],
            'footer' => ['title' => 'Konten Footer', 'desc' => 'Ringkasan footer dan teks hak cipta bagian bawah website.'],
        ];
    @endphp

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        @foreach($groupTitles as $groupKey => $meta)
            @if($groupedSettings->has($groupKey))
                <section class="border coastal-hairline bg-warm-white p-6 dark:bg-[#141f24] sm:p-8">
                    <div class="border-b coastal-hairline pb-4">
                        <h2 class="font-editorial text-2xl font-medium text-ocean-deep dark:text-warm-white">{{ $meta['title'] }}</h2>
                        <p class="mt-1 text-xs text-charcoal-soft dark:text-white/60">{{ $meta['desc'] }}</p>
                    </div>

                    <div class="mt-6 space-y-5">
                        @foreach($groupedSettings->get($groupKey) as $setting)
                            @if($setting->type === 'image')
                                <x-admin.image-field
                                    :id="'setting-img-' . $setting->key"
                                    :label="$setting->label"
                                    :fileName="'files[' . $setting->key . ']'"
                                    :existingName="'existing_media[' . $setting->key . ']'"
                                    :removeName="'remove_files[' . $setting->key . ']'"
                                    :currentPath="$setting->value"
                                    :allowRemove="true"
                                    :showMetaFields="false"
                                    :mediaFiles="$mediaFiles"
                                />
                            @elseif($setting->type === 'boolean')
                                <div class="flex items-center justify-between border coastal-hairline bg-[#f8f5ef] px-4 py-3 dark:bg-[#162126]">
                                    <label for="setting-{{ $setting->key }}" class="text-sm font-medium">{{ $setting->label }}</label>
                                    <input type="hidden" name="settings[{{ $setting->key }}]" value="0">
                                    <input
                                        id="setting-{{ $setting->key }}"
                                        type="checkbox"
                                        name="settings[{{ $setting->key }}]"
                                        value="1"
                                        @checked(old('settings.' . $setting->key, $setting->value) === '1')
                                        class="h-4 w-4 accent-ocean dark:accent-turquoise-bright"
                                    >
                                </div>
                            @elseif($setting->type === 'textarea')
                                <div>
                                    <label for="setting-{{ $setting->key }}" class="mb-1.5 block text-xs font-semibold tracking-wider uppercase text-charcoal-soft dark:text-white/75">
                                        {{ $setting->label }}
                                    </label>
                                    <textarea
                                        id="setting-{{ $setting->key }}"
                                        name="settings[{{ $setting->key }}]"
                                        rows="3"
                                        class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm focus:border-ocean focus:outline-none dark:bg-[#10171a] dark:focus:border-turquoise-bright"
                                    >{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                                </div>
                            @else
                                <div>
                                    <label for="setting-{{ $setting->key }}" class="mb-1.5 block text-xs font-semibold tracking-wider uppercase text-charcoal-soft dark:text-white/75">
                                        {{ $setting->label }}
                                    </label>
                                    <input
                                        id="setting-{{ $setting->key }}"
                                        type="text"
                                        name="settings[{{ $setting->key }}]"
                                        value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                        class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm focus:border-ocean focus:outline-none dark:bg-[#10171a] dark:focus:border-turquoise-bright"
                                    >
                                </div>
                            @endif
                        @endforeach
                    </div>
                </section>
            @endif
        @endforeach

        <div class="sticky bottom-4 z-20 flex justify-end">
            <button
                type="submit"
                class="rounded-[2px] bg-ocean px-7 py-3.5 text-sm font-semibold tracking-wide text-warm-white shadow-lg transition-colors hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal dark:hover:bg-white"
            >
                Simpan Seluruh Pengaturan
            </button>
        </div>
    </form>
@endsection

