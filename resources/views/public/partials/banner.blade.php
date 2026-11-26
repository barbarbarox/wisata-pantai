@php
    $bannerImg = \App\Models\SiteSetting::imageUrlFor($settings['promo_banner_image'] ?? null);
    $bannerQuote = $settings['promo_banner_quote'] ?? '';
@endphp

@if($bannerImg || $bannerQuote)
    <section class="relative overflow-hidden border-b coastal-hairline bg-ocean-deep py-20 text-warm-white sm:py-28">
        @if($bannerImg)
            <img
                src="{{ $bannerImg }}"
                alt="Suasana pesisir Pantai Selat Baru"
                class="absolute inset-0 h-full w-full object-cover object-center opacity-45"
                loading="lazy"
            >
        @endif
        <div class="absolute inset-0 bg-gradient-to-r from-[#09242f]/90 via-[#09242f]/75 to-[#09242f]/65" aria-hidden="true"></div>

        <div class="relative z-10 mx-auto max-w-5xl px-5 sm:px-8 lg:px-10" data-reveal>
            <p class="text-[11px] font-semibold tracking-[0.26em] uppercase text-turquoise-bright">
                {{ $settings['promo_banner_eyebrow'] ?? 'CATATAN PESISIR' }}
            </p>
            <blockquote class="mt-4 font-editorial text-2xl leading-[1.35] font-normal text-warm-white sm:text-3xl lg:text-4xl">
                "{{ $bannerQuote }}"
            </blockquote>
        </div>
    </section>
@endif

