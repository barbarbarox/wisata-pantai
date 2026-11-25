<section id="destinasi" class="border-b coastal-hairline bg-sand/45 py-20 dark:bg-[#131c20] sm:py-28">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">
        <div class="grid grid-cols-12 items-end gap-6 border-b coastal-hairline pb-8" data-reveal>
            <div class="col-span-12 lg:col-span-7">
                <p class="text-[11px] font-semibold tracking-[0.24em] uppercase text-turquoise dark:text-turquoise-bright">
                    {{ $settings['section_destinations_eyebrow'] ?? 'JELAJAH KAWASAN' }}
                </p>
                <h2 class="mt-2.5 font-editorial text-3xl font-medium tracking-tight text-ocean-deep dark:text-warm-white sm:text-4xl lg:text-[2.75rem]">
                    {{ $settings['section_destinations_title'] ?? 'Sudut Pantai dan Bentang Pesisir' }}
                </h2>
            </div>
            <div class="col-span-12 lg:col-span-5">
                <p class="text-sm leading-relaxed text-charcoal-soft dark:text-[#bac4c5] sm:text-[15px]">
                    {{ $settings['section_destinations_subtitle'] ?? '' }}
                </p>
            </div>
        </div>

        @if($destinations->isNotEmpty())
            @php
                $leadSpot = $destinations->first();
                $remainingSpots = $destinations->slice(1)->values();
            @endphp

            {{-- Editorial Featured Spot (Asymmetric 7/5 Spread) --}}
            <article class="mt-12 grid grid-cols-12 border coastal-hairline bg-warm-white dark:bg-[#162024]" data-reveal>
                <div class="col-span-12 lg:col-span-7">
                    @if($leadSpot->image_url)
                        <div class="aspect-[16/10] h-full w-full overflow-hidden bg-sand">
                            <img
                                src="{{ $leadSpot->image_url }}"
                                alt="{{ $leadSpot->image_alt ?: $leadSpot->name }}"
                                style="object-position: {{ $leadSpot->focal_point_style }};"
                                class="h-full w-full object-cover transition-transform duration-700 hover:scale-[1.03]"
                                loading="lazy"
                            >
                        </div>
                    @endif
                </div>

                <div class="col-span-12 flex flex-col justify-between p-7 sm:p-10 lg:col-span-5">
                    <div>
                        <div class="flex items-center justify-between gap-4 border-b coastal-hairline pb-4">
                            <span class="text-[11px] font-semibold tracking-[0.2em] uppercase text-muted-green dark:text-turquoise-bright">
                                {{ $leadSpot->category }}
                            </span>
                            <span class="font-mono text-xs text-charcoal-soft dark:text-white/50">01</span>
                        </div>

                        <h3 class="mt-6 font-editorial text-2xl font-medium leading-snug text-ocean-deep dark:text-warm-white sm:text-3xl">
                            {{ $leadSpot->name }}
                        </h3>

                        <p class="mt-4 text-[15px] leading-relaxed text-charcoal-soft dark:text-[#c7cfd0]">
                            {{ $leadSpot->short_description }}
                        </p>

                        @if($leadSpot->additional_info)
                            <p class="mt-5 border-l-2 border-turquoise pl-3.5 text-xs leading-relaxed text-charcoal dark:text-white/80">
                                {{ $leadSpot->additional_info }}
                            </p>
                        @endif
                    </div>

                    <div class="mt-8 pt-4">
                        <button
                            type="button"
                            data-spot-trigger="{{ json_encode([
                                'name' => $leadSpot->name,
                                'category' => $leadSpot->category,
                                'description' => $leadSpot->description,
                                'additional_info' => $leadSpot->additional_info,
                                'image' => $leadSpot->image_url,
                                'alt' => $leadSpot->image_alt ?: $leadSpot->name,
                                'focal' => $leadSpot->focal_point_style,
                            ]) }}"
                            class="inline-flex items-center gap-2 text-xs font-semibold tracking-[0.16em] uppercase text-ocean transition-colors hover:text-turquoise dark:text-turquoise-bright dark:hover:text-white"
                        >
                            <span>Baca Catatan Spot</span>
                            <i data-lucide="arrow-up-right" class="h-4 w-4" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </article>

            {{-- Varied Asymmetric Grid for Remaining Spots --}}
            @if($remainingSpots->isNotEmpty())
                <div class="mt-8 grid grid-cols-12 gap-6 lg:gap-8">
                    @foreach($remainingSpots as $index => $spot)
                        @php
                            $isWideRow = $index < 2;
                            $colSpan = $isWideRow ? 'col-span-12 md:col-span-6' : 'col-span-12 md:col-span-4';
                            $aspect = $isWideRow ? 'aspect-[16/10]' : 'aspect-[4/3]';
                        @endphp
                        <article class="{{ $colSpan }} flex flex-col border coastal-hairline bg-warm-white dark:bg-[#162024]" data-reveal>
                            @if($spot->image_url)
                                <div class="{{ $aspect }} overflow-hidden border-b coastal-hairline bg-sand">
                                    <img
                                        src="{{ $spot->image_url }}"
                                        alt="{{ $spot->image_alt ?: $spot->name }}"
                                        style="object-position: {{ $spot->focal_point_style }};"
                                        class="h-full w-full object-cover transition-transform duration-700 hover:scale-[1.03]"
                                        loading="lazy"
                                    >
                                </div>
                            @endif

                            <div class="flex flex-1 flex-col justify-between p-6">
                                <div>
                                    <div class="flex items-center justify-between gap-2 text-[11px]">
                                        <span class="font-semibold tracking-[0.18em] uppercase text-muted-green dark:text-turquoise-bright">
                                            {{ $spot->category }}
                                        </span>
                                        <span class="font-mono text-charcoal-soft dark:text-white/45">
                                            {{ str_pad((string) ($index + 2), 2, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </div>

                                    <h3 class="mt-3 font-editorial text-xl font-medium text-ocean-deep dark:text-warm-white sm:text-2xl">
                                        {{ $spot->name }}
                                    </h3>

                                    <p class="mt-2.5 text-sm leading-relaxed text-charcoal-soft dark:text-[#c0c8c9]">
                                        {{ $spot->short_description }}
                                    </p>
                                </div>

                                <div class="mt-5 flex items-center justify-between border-t coastal-hairline pt-4">
                                    <span class="text-xs text-charcoal-soft dark:text-white/60">
                                        {{ \Illuminate\Support\Str::limit($spot->additional_info ?: 'Kawasan Pesisir Selat Baru', 48) }}
                                    </span>
                                    <button
                                        type="button"
                                        data-spot-trigger="{{ json_encode([
                                            'name' => $spot->name,
                                            'category' => $spot->category,
                                            'description' => $spot->description,
                                            'additional_info' => $spot->additional_info,
                                            'image' => $spot->image_url,
                                            'alt' => $spot->image_alt ?: $spot->name,
                                            'focal' => $spot->focal_point_style,
                                        ]) }}"
                                        class="inline-flex shrink-0 items-center gap-1 text-xs font-semibold tracking-wider uppercase text-ocean hover:text-turquoise dark:text-turquoise-bright"
                                    >
                                        <span>Detail</span>
                                        <i data-lucide="arrow-up-right" class="h-3.5 w-3.5" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
</section>

{{-- Spot Detail Modal --}}
<div
    data-spot-modal
    class="fixed inset-0 z-50 hidden flex items-center justify-center bg-charcoal/75 p-4 backdrop-blur-xs sm:p-6"
    role="dialog"
    aria-modal="true"
    aria-labelledby="spot-modal-title"
>
    <div class="absolute inset-0" data-spot-modal-close></div>
    <div class="relative z-10 max-h-[90vh] w-full max-w-3xl overflow-y-auto border coastal-hairline bg-warm-white text-charcoal shadow-2xl dark:bg-[#141d21] dark:text-[#f0ece3]">
        <div class="flex items-center justify-between border-b coastal-hairline px-6 py-4">
            <span data-spot-modal-category class="text-[11px] font-semibold tracking-[0.2em] uppercase text-turquoise dark:text-turquoise-bright"></span>
            <button
                type="button"
                data-spot-modal-close
                aria-label="Tutup Detail Spot"
                class="inline-flex h-8 w-8 items-center justify-center border coastal-hairline hover:bg-sand dark:hover:bg-white/10"
            >
                <i data-lucide="x" class="h-4 w-4"></i>
            </button>
        </div>

        <div class="aspect-[16/9] w-full overflow-hidden bg-sand dark:bg-[#0f1619]">
            <img data-spot-modal-image src="" alt="" class="h-full w-full object-cover">
        </div>

        <div class="p-6 sm:p-8">
            <h3 id="spot-modal-title" data-spot-modal-title class="font-editorial text-2xl font-medium text-ocean-deep dark:text-warm-white sm:text-3xl"></h3>
            <p data-spot-modal-description class="mt-4 whitespace-pre-line text-[15px] leading-[1.75] text-charcoal-soft dark:text-[#c7cfd0]"></p>
            <div data-spot-modal-info-wrap class="mt-6 border-l-2 border-turquoise bg-sand/55 p-4 dark:bg-[#1b272c]">
                <p class="text-[11px] font-semibold tracking-[0.18em] uppercase text-ocean dark:text-turquoise-bright">Catatan Kawasan</p>
                <p data-spot-modal-info class="mt-1.5 text-sm text-charcoal dark:text-white/85"></p>
            </div>
        </div>
    </div>
</div>

