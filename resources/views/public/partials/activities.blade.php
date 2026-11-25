<section id="aktivitas" class="border-b coastal-hairline bg-warm-white py-20 dark:bg-[#10171a] sm:py-28">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">
        <div class="grid grid-cols-12 gap-10 lg:gap-14">
            <div class="col-span-12 lg:col-span-5 lg:sticky lg:top-24 lg:self-start" data-reveal>
                <p class="text-[11px] font-semibold tracking-[0.24em] uppercase text-muted-green dark:text-turquoise-bright">
                    {{ $settings['section_activities_eyebrow'] ?? 'RAGAM KEGIATAN' }}
                </p>
                <h2 class="mt-2.5 font-editorial text-3xl font-medium tracking-tight text-ocean-deep dark:text-warm-white sm:text-4xl lg:text-[2.75rem]">
                    {{ $settings['section_activities_title'] ?? 'Aktivitas Wisata Sepanjang Hari' }}
                </h2>
                <p class="mt-4 max-w-[46ch] text-[15px] leading-relaxed text-charcoal-soft dark:text-[#c0c8c9]">
                    {{ $settings['section_activities_subtitle'] ?? '' }}
                </p>

                @if($activities->isNotEmpty() && $activities->first()->image_url)
                    <figure class="mt-8 hidden border coastal-hairline bg-sand/50 p-2 dark:bg-[#162024] lg:block">
                        <div class="aspect-[4/3] overflow-hidden">
                            <img
                                src="{{ $activities->first()->image_url }}"
                                alt="{{ $activities->first()->image_alt ?: $activities->first()->title }}"
                                style="object-position: {{ $activities->first()->focal_point_style }};"
                                class="h-full w-full object-cover"
                                loading="lazy"
                            >
                        </div>
                        <figcaption class="mt-2.5 px-1 text-xs text-charcoal-soft dark:text-white/65">
                            {{ $activities->first()->title }}
                        </figcaption>
                    </figure>
                @endif
            </div>

            <div class="col-span-12 lg:col-span-7">
                <div class="divide-y coastal-hairline border-y coastal-hairline">
                    @foreach($activities as $idx => $activity)
                        <article class="grid grid-cols-12 items-start gap-5 py-8 first:pt-6 last:pb-6" data-reveal>
                            <div class="col-span-12 sm:col-span-4">
                                @if($activity->image_url)
                                    <div class="aspect-[4/3] overflow-hidden border coastal-hairline bg-sand dark:bg-[#162024]">
                                        <img
                                            src="{{ $activity->image_url }}"
                                            alt="{{ $activity->image_alt ?: $activity->title }}"
                                            style="object-position: {{ $activity->focal_point_style }};"
                                            class="h-full w-full object-cover transition-transform duration-500 hover:scale-[1.03]"
                                            loading="lazy"
                                        >
                                    </div>
                                @else
                                    <div class="flex aspect-[4/3] items-center justify-center border coastal-hairline bg-sand/60 dark:bg-[#162024]">
                                        <i data-lucide="waves" class="h-6 w-6 text-ocean/50 dark:text-turquoise-bright/60"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="col-span-12 sm:col-span-8">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span class="text-[11px] font-semibold tracking-[0.18em] uppercase text-turquoise dark:text-turquoise-bright">
                                        {{ str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT) }} / {{ $activity->category }}
                                    </span>
                                    @if($activity->best_time)
                                        <span class="inline-flex items-center gap-1.5 text-xs text-charcoal-soft dark:text-white/65">
                                            <i data-lucide="clock" class="h-3.5 w-3.5" aria-hidden="true"></i>
                                            {{ $activity->best_time }}
                                        </span>
                                    @endif
                                </div>

                                <h3 class="mt-2 font-editorial text-2xl font-medium text-ocean-deep dark:text-warm-white">
                                    {{ $activity->title }}
                                </h3>
                                <p class="mt-2.5 text-sm leading-relaxed text-charcoal-soft dark:text-[#c0c8c9]">
                                    {{ $activity->description }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

