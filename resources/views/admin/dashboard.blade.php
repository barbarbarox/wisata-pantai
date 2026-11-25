@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Ringkasan Konten')

@section('content')
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <a href="{{ route('admin.destinations.index') }}" class="border coastal-hairline bg-warm-white p-5 transition-colors hover:border-ocean dark:bg-[#141f24] dark:hover:border-turquoise-bright">
            <div class="flex items-center justify-between text-charcoal-soft dark:text-white/60">
                <span class="text-[11px] font-semibold tracking-[0.18em] uppercase">Spot Wisata</span>
                <i data-lucide="map" class="h-4 w-4 text-ocean dark:text-turquoise-bright"></i>
            </div>
            <p class="mt-3 font-editorial text-3xl font-medium">{{ $stats['destinations_total'] }}</p>
            <p class="mt-1 text-xs text-charcoal-soft dark:text-white/55">{{ $stats['destinations_active'] }} aktif ditampilkan</p>
        </a>

        <a href="{{ route('admin.galleries.index') }}" class="border coastal-hairline bg-warm-white p-5 transition-colors hover:border-ocean dark:bg-[#141f24] dark:hover:border-turquoise-bright">
            <div class="flex items-center justify-between text-charcoal-soft dark:text-white/60">
                <span class="text-[11px] font-semibold tracking-[0.18em] uppercase">Galeri Foto</span>
                <i data-lucide="images" class="h-4 w-4 text-ocean dark:text-turquoise-bright"></i>
            </div>
            <p class="mt-3 font-editorial text-3xl font-medium">{{ $stats['galleries_total'] }}</p>
            <p class="mt-1 text-xs text-charcoal-soft dark:text-white/55">{{ $stats['galleries_active'] }} foto dipublikasikan</p>
        </a>

        <a href="{{ route('admin.umkm.index') }}" class="border coastal-hairline bg-warm-white p-5 transition-colors hover:border-ocean dark:bg-[#141f24] dark:hover:border-turquoise-bright">
            <div class="flex items-center justify-between text-charcoal-soft dark:text-white/60">
                <span class="text-[11px] font-semibold tracking-[0.18em] uppercase">Data UMKM</span>
                <i data-lucide="store" class="h-4 w-4 text-ocean dark:text-turquoise-bright"></i>
            </div>
            <p class="mt-3 font-editorial text-3xl font-medium">{{ $stats['umkm_total'] }}</p>
            <p class="mt-1 text-xs text-charcoal-soft dark:text-white/55">{{ $stats['umkm_active'] }} unit aktif</p>
        </a>

        <a href="{{ route('admin.activities.index') }}" class="border coastal-hairline bg-warm-white p-5 transition-colors hover:border-ocean dark:bg-[#141f24] dark:hover:border-turquoise-bright">
            <div class="flex items-center justify-between text-charcoal-soft dark:text-white/60">
                <span class="text-[11px] font-semibold tracking-[0.18em] uppercase">Aktivitas</span>
                <i data-lucide="compass" class="h-4 w-4 text-ocean dark:text-turquoise-bright"></i>
            </div>
            <p class="mt-3 font-editorial text-3xl font-medium">{{ $stats['activities_total'] }}</p>
            <p class="mt-1 text-xs text-charcoal-soft dark:text-white/55">{{ $stats['activities_active'] }} aktivitas aktif</p>
        </a>

        <div class="border coastal-hairline bg-ocean p-5 text-warm-white dark:bg-[#173642]">
            <div class="flex items-center justify-between text-white/75">
                <span class="text-[11px] font-semibold tracking-[0.18em] uppercase">Total Konten</span>
                <i data-lucide="layers" class="h-4 w-4 text-turquoise-bright"></i>
            </div>
            <p class="mt-3 font-editorial text-3xl font-medium">{{ $stats['content_total'] }}</p>
            <p class="mt-1 text-xs text-white/75">{{ $stats['settings_total'] }} entri konfigurasi situs</p>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-12">
        <section class="border coastal-hairline bg-warm-white p-6 dark:bg-[#141f24] lg:col-span-7">
            <div class="flex items-center justify-between border-b coastal-hairline pb-4">
                <div>
                    <p class="text-[11px] font-semibold tracking-[0.18em] uppercase text-turquoise dark:text-turquoise-bright">Tampilan Utama</p>
                    <h2 class="mt-1 font-editorial text-2xl font-medium">Hero Aktif Saat Ini</h2>
                </div>
                <a href="{{ route('admin.heroes.index') }}" class="rounded-[2px] border coastal-hairline px-3 py-1.5 text-xs font-semibold hover:bg-sand dark:hover:bg-white/10">
                    Kelola Hero
                </a>
            </div>

            @if($activeHero)
                <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-12">
                    <div class="sm:col-span-5">
                        @if($activeHero->image_url)
                            <div class="aspect-[16/10] overflow-hidden border coastal-hairline">
                                <img src="{{ $activeHero->image_url }}" alt="{{ $activeHero->title }}" class="h-full w-full object-cover">
                            </div>
                        @endif
                    </div>
                    <div class="sm:col-span-7">
                        <span class="text-[10px] font-semibold tracking-[0.2em] uppercase text-muted-green dark:text-turquoise-bright">
                            {{ $activeHero->eyebrow }}
                        </span>
                        <h3 class="mt-1 font-editorial text-xl font-medium">{{ $activeHero->title }}</h3>
                        <p class="mt-2 text-xs leading-relaxed text-charcoal-soft dark:text-white/70">
                            {{ $activeHero->subtitle }}
                        </p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <a href="{{ route('admin.heroes.edit', $activeHero) }}" class="rounded-[2px] bg-ocean px-3 py-1.5 text-xs font-semibold text-white dark:bg-turquoise-bright dark:text-charcoal">
                                Edit Hero Aktif
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </section>

        <section class="border coastal-hairline bg-warm-white p-6 dark:bg-[#141f24] lg:col-span-5">
            <div class="border-b coastal-hairline pb-4">
                <p class="text-[11px] font-semibold tracking-[0.18em] uppercase text-muted-green dark:text-turquoise-bright">Akses Cepat</p>
                <h2 class="mt-1 font-editorial text-2xl font-medium">Tambah &amp; Perbarui Konten</h2>
            </div>

            <div class="mt-4 divide-y coastal-hairline text-sm">
                <a href="{{ route('admin.settings.edit') }}" class="flex items-center justify-between py-3 hover:text-ocean dark:hover:text-turquoise-bright">
                    <span>Ubah Judul, Bagian Tentang, Lokasi &amp; Footer</span>
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
                <a href="{{ route('admin.destinations.create') }}" class="flex items-center justify-between py-3 hover:text-ocean dark:hover:text-turquoise-bright">
                    <span>Tambah Spot Wisata Baru</span>
                    <i data-lucide="plus" class="h-4 w-4"></i>
                </a>
                <a href="{{ route('admin.umkm.create') }}" class="flex items-center justify-between py-3 hover:text-ocean dark:hover:text-turquoise-bright">
                    <span>Tambah Data UMKM Lokal</span>
                    <i data-lucide="plus" class="h-4 w-4"></i>
                </a>
                <a href="{{ route('admin.galleries.create') }}" class="flex items-center justify-between py-3 hover:text-ocean dark:hover:text-turquoise-bright">
                    <span>Unggah Foto ke Galeri</span>
                    <i data-lucide="upload" class="h-4 w-4"></i>
                </a>
                <a href="{{ route('admin.media.index') }}" class="flex items-center justify-between py-3 hover:text-ocean dark:hover:text-turquoise-bright">
                    <span>Kelola Pustaka Media &amp; Background</span>
                    <i data-lucide="folder-open" class="h-4 w-4"></i>
                </a>
            </div>
        </section>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-2">
        <section class="border coastal-hairline bg-warm-white p-6 dark:bg-[#141f24]">
            <div class="flex items-center justify-between border-b coastal-hairline pb-3">
                <h3 class="font-editorial text-xl font-medium">Spot Wisata Terbaru</h3>
                <a href="{{ route('admin.destinations.index') }}" class="text-xs font-semibold text-ocean dark:text-turquoise-bright">Lihat Semua</a>
            </div>
            <ul class="mt-3 divide-y coastal-hairline">
                @foreach($recentDestinations as $spot)
                    <li class="flex items-center justify-between gap-4 py-3">
                        <div class="flex min-w-0 items-center gap-3">
                            @if($spot->image_url)
                                <img src="{{ $spot->image_url }}" alt="{{ $spot->name }}" class="h-10 w-14 shrink-0 border coastal-hairline object-cover">
                            @endif
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium">{{ $spot->name }}</p>
                                <p class="text-xs text-charcoal-soft dark:text-white/55">{{ $spot->category }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.destinations.edit', $spot) }}" class="text-xs font-semibold text-ocean hover:underline dark:text-turquoise-bright">Edit</a>
                    </li>
                @endforeach
            </ul>
        </section>

        <section class="border coastal-hairline bg-warm-white p-6 dark:bg-[#141f24]">
            <div class="flex items-center justify-between border-b coastal-hairline pb-3">
                <h3 class="font-editorial text-xl font-medium">Direktori UMKM Terbaru</h3>
                <a href="{{ route('admin.umkm.index') }}" class="text-xs font-semibold text-ocean dark:text-turquoise-bright">Lihat Semua</a>
            </div>
            <ul class="mt-3 divide-y coastal-hairline">
                @foreach($recentUmkm as $u)
                    <li class="flex items-center justify-between gap-4 py-3">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-medium">{{ $u->business_name }}</p>
                            <p class="text-xs text-charcoal-soft dark:text-white/55">{{ $u->product_type }}</p>
                        </div>
                        <a href="{{ route('admin.umkm.edit', $u) }}" class="text-xs font-semibold text-ocean hover:underline dark:text-turquoise-bright">Edit</a>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>
@endsection

