@php
    $galleryCategories = $galleries->pluck('category')->filter()->unique()->values();
@endphp

<section id="galeri" class="border-b coastal-hairline bg-warm-white py-20 dark:bg-[#10171a] sm:py-28">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">
        <div class="grid grid-cols-12 items-end gap-6 border-b coastal-hairline pb-8" data-reveal>
            <div class="col-span-12 lg:col-span-7">
                <p class="text-[11px] font-semibold tracking-[0.24em] uppercase text-turquoise dark:text-turquoise-bright">
                    {{ $settings['section_gallery_eyebrow'] ?? 'ARSIP VISUAL' }}
                </p>
                <h2 class="mt-2.5 font-editorial text-3xl font-medium tracking-tight text-ocean-deep dark:text-warm-white sm:text-4xl lg:text-[2.75rem]">
                    {{ $settings['section_gallery_title'] ?? 'Galeri Foto Pantai Selat Baru' }}
                </h2>
            </div>
            <div class="col-span-12 lg:col-span-5">
                <p class="text-sm leading-relaxed text-charcoal-soft dark:text-[#bac4c5] sm:text-[15px]">
                    {{ $settings['section_gallery_subtitle'] ?? '' }}
                </p>
            </div>
        </div>

        @if($galleryCategories->isNotEmpty())
            <div class="mt-7 flex flex-wrap items-center gap-2" role="toolbar" aria-label="Filter Kategori Galeri">
                <button
                    type="button"
                    data-gallery-filter="all"
                    aria-pressed="true"
                    class="rounded-[2px] border coastal-hairline bg-ocean px-4 py-2 text-xs font-semibold tracking-wider uppercase text-white transition-colors dark:bg-turquoise-bright dark:text-charcoal"
                >
                    Semua ({{ $galleries->count() }})
                </button>
                @foreach($galleryCategories as $cat)
                    <button
                        type="button"
                        data-gallery-filter="{{ $cat }}"
                        aria-pressed="false"
                        class="rounded-[2px] border coastal-hairline px-4 py-2 text-xs font-medium tracking-wider uppercase text-charcoal transition-colors hover:bg-sand dark:text-white/80 dark:hover:bg-white/10"
                    >
                        {{ $cat }}
                    </button>
                @endforeach
            </div>
        @endif

        @if($galleries->isNotEmpty())
            <div class="mt-8 grid grid-cols-1 gap-4 md:grid-cols-3 md:auto-rows-[250px] lg:gap-5">
                @foreach($galleries as $item)
                    @php
                        $gridSpanClass = match ($item->aspect_ratio) {
                            'wide' => 'md:col-span-2 aspect-[16/9] md:aspect-auto',
                            'portrait' => 'md:row-span-2 aspect-[3/4] md:aspect-auto',
                            'square' => 'aspect-square md:aspect-auto',
                            default => 'aspect-[4/3] md:aspect-auto',
                        };
                    @endphp
                    <button
                        type="button"
                        data-category="{{ $item->category }}"
                        data-gallery-item="{{ json_encode([
                            'title' => $item->title,
                            'caption' => $item->caption,
                            'category' => $item->category,
                            'image' => $item->image_url,
                            'alt' => $item->image_alt ?: $item->title,
                        ]) }}"
                        class="{{ $gridSpanClass }} group relative overflow-hidden border coastal-hairline bg-sand text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-turquoise dark:bg-[#162024]"
                        data-reveal
                    >
                        <img
                            src="{{ $item->image_url }}"
                            alt="{{ $item->image_alt ?: $item->title }}"
                            style="object-position: {{ $item->focal_point_style }};"
                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-[1.04]"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-[#081a22]/80 via-[#081a22]/15 to-transparent opacity-85 transition-opacity duration-300 md:opacity-0 md:group-hover:opacity-100 md:group-focus-visible:opacity-100"></div>

                        <div class="absolute inset-x-0 bottom-0 flex items-end justify-between gap-3 p-4 text-warm-white transition-transform duration-300 md:translate-y-2 md:opacity-0 md:group-hover:translate-y-0 md:group-hover:opacity-100 md:group-focus-visible:translate-y-0 md:group-focus-visible:opacity-100">
                            <div>
                                <span class="block text-[10px] font-semibold tracking-[0.2em] uppercase text-turquoise-bright">
                                    {{ $item->category }}
                                </span>
                                <span class="mt-0.5 block font-editorial text-lg font-medium leading-tight">
                                    {{ $item->title }}
                                </span>
                            </div>
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center border border-white/30 bg-black/25">
                                <i data-lucide="maximize-2" class="h-3.5 w-3.5" aria-hidden="true"></i>
                            </span>
                        </div>
                    </button>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- Interactive Gallery Lightbox --}}
<div
    data-lightbox
    class="fixed inset-0 z-50 hidden flex flex-col justify-between bg-[#081216]/95 p-4 text-warm-white backdrop-blur-sm sm:p-8"
    role="dialog"
    aria-modal="true"
    aria-label="Penampil Foto Galeri"
>
    <div class="flex items-center justify-between border-b border-white/15 pb-4">
        <div class="flex items-center gap-4">
            <span data-lightbox-counter class="font-mono text-xs text-white/70">1 / 1</span>
            <span data-lightbox-category class="text-[11px] font-semibold tracking-[0.2em] uppercase text-turquoise-bright"></span>
        </div>
        <button
            type="button"
            data-lightbox-close
            aria-label="Tutup Galeri"
            class="inline-flex h-9 w-9 items-center justify-center border border-white/25 transition-colors hover:bg-white/10"
        >
            <i data-lucide="x" class="h-4 w-4"></i>
        </button>
    </div>

    <div class="relative my-auto flex min-h-0 flex-1 items-center justify-center py-4">
        <button
            type="button"
            data-lightbox-prev
            aria-label="Foto Sebelumnya"
            class="absolute left-0 z-10 inline-flex h-11 w-11 items-center justify-center border border-white/25 bg-[#081216]/75 transition-colors hover:bg-white/15 sm:left-2"
        >
            <i data-lucide="chevron-left" class="h-5 w-5"></i>
        </button>

        <figure class="flex max-h-full max-w-5xl flex-col items-center">
            <img
                data-lightbox-img
                src=""
                alt=""
                class="max-h-[70vh] w-auto border border-white/15 object-contain"
            >
        </figure>

        <button
            type="button"
            data-lightbox-next
            aria-label="Foto Berikutnya"
            class="absolute right-0 z-10 inline-flex h-11 w-11 items-center justify-center border border-white/25 bg-[#081216]/75 transition-colors hover:bg-white/15 sm:right-2"
        >
            <i data-lucide="chevron-right" class="h-5 w-5"></i>
        </button>
    </div>

    <div class="mx-auto w-full max-w-3xl border-t border-white/15 pt-4 text-center">
        <h3 data-lightbox-title class="font-editorial text-xl font-medium sm:text-2xl"></h3>
        <p data-lightbox-caption class="mt-1.5 text-xs leading-relaxed text-white/75 sm:text-sm"></p>
    </div>
</div>

