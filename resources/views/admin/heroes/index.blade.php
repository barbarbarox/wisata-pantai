@extends('layouts.admin')

@section('title', 'Kelola Hero & Banner')
@section('page-title', 'Hero & Banner Utama')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-charcoal-soft dark:text-white/70">
            Pilih variasi hero aktif atau ubah foto latar, tajuk, dan tombol CTA pada bagian atas homepage.
        </p>
        <a
            href="{{ route('admin.heroes.create') }}"
            class="inline-flex items-center gap-2 rounded-[2px] bg-ocean px-4 py-2.5 text-xs font-semibold tracking-wide text-warm-white hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal"
        >
            <i data-lucide="plus" class="h-4 w-4"></i>
            <span>Tambah Variasi Hero</span>
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
        @foreach($heroes as $hero)
            <article class="flex flex-col justify-between border coastal-hairline bg-warm-white dark:bg-[#141f24] {{ $hero->is_active ? 'ring-1 ring-ocean dark:ring-turquoise-bright' : '' }}">
                <div>
                    @if($hero->image_url)
                        <div class="relative aspect-[16/9] overflow-hidden border-b coastal-hairline bg-sand">
                            <img src="{{ $hero->image_url }}" alt="{{ $hero->image_alt ?: $hero->title }}" style="object-position: {{ $hero->focal_point_style }};" class="h-full w-full object-cover">
                            @if($hero->is_active)
                                <span class="absolute top-3 left-3 bg-ocean px-2.5 py-1 text-[10px] font-semibold tracking-widest uppercase text-warm-white dark:bg-turquoise-bright dark:text-charcoal">
                                    Hero Aktif
                                </span>
                            @endif
                        </div>
                    @endif

                    <div class="p-6">
                        <div class="flex items-center justify-between text-[11px] text-charcoal-soft dark:text-white/55">
                            <span class="font-semibold tracking-[0.18em] uppercase">{{ $hero->eyebrow }}</span>
                            <span>Urutan #{{ $hero->sort_order }}</span>
                        </div>
                        <h2 class="mt-2 font-editorial text-2xl font-medium">{{ $hero->title }}</h2>
                        <p class="mt-2 text-xs leading-relaxed text-charcoal-soft dark:text-white/70">{{ $hero->subtitle }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-2 border-t coastal-hairline px-6 py-4">
                    <div class="flex items-center gap-2">
                        @if(! $hero->is_active)
                            <form method="POST" action="{{ route('admin.heroes.activate', $hero) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="rounded-[2px] bg-ocean px-3 py-1.5 text-xs font-semibold text-white hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal">
                                    Jadikan Aktif
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('admin.heroes.edit', $hero) }}" class="rounded-[2px] border coastal-hairline px-3 py-1.5 text-xs font-semibold hover:bg-sand dark:hover:bg-white/10">
                            Edit
                        </a>
                    </div>

                    @if($heroes->count() > 1)
                        <form method="POST" action="{{ route('admin.heroes.destroy', $hero) }}" data-confirm="Hapus variasi hero ini?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-[2px] border border-red-500/30 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-500/10 dark:text-red-300">
                                Hapus
                            </button>
                        </form>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
@endsection

