@extends('layouts.admin')

@section('title', 'Kelola Galeri Foto')
@section('page-title', 'Galeri Foto Pantai')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-charcoal-soft dark:text-white/70">Atur foto, rasio tampilan editorial, urutan, serta status foto unggulan di galeri publik.</p>
        <a href="{{ route('admin.galleries.create') }}" class="inline-flex items-center gap-2 rounded-[2px] bg-ocean px-4 py-2.5 text-xs font-semibold text-warm-white hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal">
            <i data-lucide="plus" class="h-4 w-4"></i>
            <span>Tambah Foto Galeri</span>
        </a>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($galleries as $item)
            <article class="flex flex-col justify-between border coastal-hairline bg-warm-white dark:bg-[#141f24]">
                <div>
                    <div class="relative aspect-[4/3] overflow-hidden border-b coastal-hairline bg-sand">
                        <img src="{{ $item->image_url }}" alt="{{ $item->image_alt ?: $item->title }}" style="object-position: {{ $item->focal_point_style }};" class="h-full w-full object-cover">
                        <div class="absolute top-2.5 left-2.5 flex gap-1.5">
                            <span class="bg-charcoal/80 px-2 py-0.5 text-[10px] font-semibold tracking-wider uppercase text-white">{{ $item->category }}</span>
                            <span class="bg-ocean/85 px-2 py-0.5 font-mono text-[10px] text-white">{{ $item->aspect_ratio }}</span>
                        </div>
                        @if($item->is_featured)
                            <span class="absolute top-2.5 right-2.5 bg-turquoise px-2 py-0.5 text-[10px] font-semibold uppercase text-white">Unggulan</span>
                        @endif
                    </div>

                    <div class="p-4">
                        <div class="flex items-center justify-between text-[11px] text-charcoal-soft dark:text-white/55">
                            <span>Urutan #{{ $item->sort_order }}</span>
                            <span>{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                        </div>
                        <h3 class="mt-1.5 font-editorial text-lg font-medium">{{ $item->title }}</h3>
                        <p class="mt-1 line-clamp-2 text-xs text-charcoal-soft dark:text-white/65">{{ $item->caption }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-between border-t coastal-hairline px-4 py-3">
                    <a href="{{ route('admin.galleries.edit', $item) }}" class="rounded-[2px] border coastal-hairline px-3 py-1.5 text-xs font-semibold hover:bg-sand dark:hover:bg-white/10">Edit</a>
                    <form method="POST" action="{{ route('admin.galleries.destroy', $item) }}" data-confirm="Hapus foto '{{ $item->title }}' dari galeri?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-[2px] border border-red-500/30 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-500/10 dark:text-red-300">Hapus</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="col-span-full border coastal-hairline bg-warm-white p-10 text-center text-sm text-charcoal-soft dark:bg-[#141f24] dark:text-white/60">
                Belum ada foto di galeri.
            </div>
        @endforelse
    </div>
@endsection

