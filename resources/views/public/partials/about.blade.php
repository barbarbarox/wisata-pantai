@php
    $aboutPrimary = \App\Models\SiteSetting::imageUrlFor($settings['about_image'] ?? null);
    $aboutSecondary = \App\Models\SiteSetting::imageUrlFor($settings['about_secondary_image'] ?? null);
    $paragraphs = array_filter(array_map('trim', preg_split("/\r\n|\n|\r/", $settings['about_description'] ?? '') ?: []));
@endphp

<section id="tentang" class="border-b coastal-hairline bg-warm-white py-20 dark:bg-[#10171a] sm:py-28">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">
        <div class="grid grid-cols-12 items-start gap-10 lg:gap-14">
            <div class="col-span-12 lg:col-span-5" data-reveal>
                <p class="text-[11px] font-semibold tracking-[0.24em] uppercase text-muted-green dark:text-turquoise-bright">
                    {{ $settings['about_eyebrow'] ?? 'MENGENAL KAWASAN' }}
                </p>
                <h2 class="mt-3 font-editorial text-3xl leading-[1.15] font-medium tracking-tight text-ocean-deep dark:text-warm-white sm:text-4xl lg:text-[2.75rem]">
                    {{ $settings['about_title'] ?? 'Pantai Landai di Tepian Selat Malaka' }}
                </h2>

                <div class="mt-7 space-y-4 text-[15px] leading-[1.75] text-charcoal-soft dark:text-[#c7cfd0]">
                    @foreach($paragraphs as $paragraph)
                        <p class="max-w-[56ch]">{{ $paragraph }}</p>
                    @endforeach
                </div>

                @if(!empty($settings['about_note']))
                    <div class="mt-8 border-t border-l-2 border-t-charcoal/12 border-l-turquoise bg-sand/55 p-5 dark:border-t-white/12 dark:bg-[#162024]">
                        <p class="text-[11px] font-semibold tracking-[0.2em] uppercase text-ocean dark:text-turquoise-bright">Konteks Geografis</p>
                        <p class="mt-2 text-sm leading-relaxed text-charcoal dark:text-[#dce2e3]">
                            {{ $settings['about_note'] }}
                        </p>
                    </div>
                @endif
            </div>

            <div class="col-span-12 lg:col-span-7" data-reveal>
                <div class="relative">
                    @if($aboutPrimary)
                        <figure class="border coastal-hairline bg-sand p-2 dark:bg-[#162024]">
                            <div class="aspect-[16/10] overflow-hidden">
                                <img
                                    src="{{ $aboutPrimary }}"
                                    alt="Pemandangan pesisir Pantai Selat Baru dari udara"
                                    class="h-full w-full object-cover transition-transform duration-700 hover:scale-[1.02]"
                                    loading="lazy"
                                >
                            </div>
                            <figcaption class="mt-2.5 flex items-center justify-between px-1 text-xs text-charcoal-soft dark:text-white/60">
                                <span>Lengkung garis pantai utara Pulau Bengkalis</span>
                                <span class="font-mono text-[11px]">Selat Malaka</span>
                            </figcaption>
                        </figure>
                    @endif

                    @if($aboutSecondary)
                        <figure class="mt-5 border coastal-hairline bg-warm-white p-2 shadow-sm dark:bg-[#162024] sm:ml-auto sm:-mt-16 sm:w-7/12 sm:relative sm:z-10">
                            <div class="aspect-[16/10] overflow-hidden">
                                <img
                                    src="{{ $aboutSecondary }}"
                                    alt="Tekstur pasir beriak dan air dangkal Pantai Selat Baru"
                                    class="h-full w-full object-cover transition-transform duration-700 hover:scale-[1.02]"
                                    loading="lazy"
                                >
                            </div>
                            <figcaption class="mt-2 px-1 text-xs text-charcoal-soft dark:text-white/65">
                                Hamparan pasir landai dengan pola riak alami saat air surut.
                            </figcaption>
                        </figure>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

