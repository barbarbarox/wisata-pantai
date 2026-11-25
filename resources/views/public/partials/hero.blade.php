@php
    $heroImage = $hero?->image_url;
    $heroAlt = $hero?->image_alt ?: ($hero?->title ?? 'Pantai Selat Baru');
    $heroFocal = $hero?->focal_point_style ?? 'center center';
@endphp

<section id="beranda" class="relative flex min-h-[88vh] items-end overflow-hidden bg-ocean-deep text-white sm:min-h-[92vh]">
    @if($heroImage)
        <div class="absolute inset-0 overflow-hidden" aria-hidden="true">
            <img
                data-hero-parallax
                src="{{ $heroImage }}"
                alt="{{ $heroAlt }}"
                style="object-position: {{ $heroFocal }};"
                class="h-full w-full scale-[1.04] object-cover transition-transform duration-75"
                fetchpriority="high"
            >
        </div>
    @endif

    <div
        class="absolute inset-0 bg-gradient-to-r from-[#071a22]/85 via-[#092935]/52 to-[#092935]/20"
        aria-hidden="true"
    ></div>
    <div
        class="absolute inset-x-0 bottom-0 h-44 bg-gradient-to-t from-[#071a22]/75 to-transparent"
        aria-hidden="true"
    ></div>

    <div class="relative z-10 mx-auto w-full max-w-7xl px-5 pb-14 pt-32 sm:px-8 sm:pb-20 lg:px-10">
        <div class="grid grid-cols-12 items-end gap-8">
            <div class="col-span-12 lg:col-span-8">
                <p class="mb-4 inline-flex items-center gap-3 text-[11px] font-semibold tracking-[0.26em] uppercase text-sand/90 sm:text-xs">
                    <span class="inline-block h-px w-8 bg-turquoise-bright" aria-hidden="true"></span>
                    {{ $hero?->eyebrow ?? 'DESTINASI WISATA BENGKALIS' }}
                </p>

                <h1 class="font-editorial text-4xl leading-[1.06] font-medium tracking-tight text-warm-white sm:text-6xl lg:text-[4.5rem]">
                    {{ $hero?->title ?? 'Pantai Selat Baru' }}
                </h1>

                <p class="mt-5 max-w-[54ch] text-base leading-relaxed text-warm-white/88 sm:text-lg">
                    {{ $hero?->subtitle ?? 'Garis pantai berpasir landai di pesisir utara Pulau Bengkalis, menghadap langsung ke perairan Selat Malaka.' }}
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-3.5">
                    <a
                        href="{{ $hero?->primary_cta_url ?? '#destinasi' }}"
                        class="inline-flex items-center gap-2.5 rounded-[2px] bg-warm-white px-6 py-3.5 text-sm font-semibold tracking-wide text-ocean-deep transition-all duration-200 hover:bg-sand focus:outline-none focus-visible:ring-2 focus-visible:ring-turquoise-bright"
                    >
                        <span>{{ $hero?->primary_cta_text ?? 'Jelajahi Pantai' }}</span>
                        <i data-lucide="arrow-right" class="h-4 w-4" aria-hidden="true"></i>
                    </a>

                    @if(!empty($hero?->secondary_cta_text))
                        <a
                            href="{{ $hero->secondary_cta_url ?: '#galeri' }}"
                            class="inline-flex items-center gap-2.5 rounded-[2px] border border-warm-white/45 bg-[#092935]/35 px-6 py-3.5 text-sm font-medium tracking-wide text-warm-white backdrop-blur-xs transition-all duration-200 hover:border-warm-white hover:bg-warm-white/15 focus:outline-none focus-visible:ring-2 focus-visible:ring-turquoise-bright"
                        >
                            <span>{{ $hero->secondary_cta_text }}</span>
                        </a>
                    @endif
                </div>
            </div>

            <div class="col-span-12 border-t border-white/20 pt-5 lg:col-span-4 lg:border-t-0 lg:border-l lg:pl-8 lg:pt-0">
                <dl class="grid grid-cols-2 gap-4 text-xs sm:grid-cols-2 lg:grid-cols-1 lg:gap-3.5">
                    <div>
                        <dt class="text-[10px] tracking-[0.2em] uppercase text-white/60">Wilayah Administratif</dt>
                        <dd class="mt-1 font-medium text-warm-white">Desa Selat Baru, Kec. Bantan, Kab. Bengkalis</dd>
                    </div>
                    <div>
                        <dt class="text-[10px] tracking-[0.2em] uppercase text-white/60">Perairan</dt>
                        <dd class="mt-1 font-medium text-warm-white">Pesisir Utara, Selat Malaka</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</section>

