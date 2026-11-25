@php
    $lat = (float) ($settings['location_latitude'] ?? 1.523000);
    $lng = (float) ($settings['location_longitude'] ?? 102.229000);
    $delta = 0.025;
    $bbox = sprintf('%.6f,%.6f,%.6f,%.6f', $lng - $delta, $lat - $delta, $lng + $delta, $lat + $delta);
    $osmEmbedUrl = "https://www.openstreetmap.org/export/embed.html?bbox={$bbox}&layer=mapnik&marker={$lat},{$lng}";
    $osmExternalUrl = "https://www.openstreetmap.org/?mlat={$lat}&mlon={$lng}#map=14/{$lat}/{$lng}";
@endphp

<section id="kontak" class="bg-sand/45 py-20 dark:bg-[#131c20] sm:py-28">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">
        <div class="grid grid-cols-12 items-end gap-6 border-b coastal-hairline pb-8" data-reveal>
            <div class="col-span-12 lg:col-span-7">
                <p class="text-[11px] font-semibold tracking-[0.24em] uppercase text-muted-green dark:text-turquoise-bright">
                    {{ $settings['section_location_eyebrow'] ?? 'PETA & AKSES' }}
                </p>
                <h2 class="mt-2.5 font-editorial text-3xl font-medium tracking-tight text-ocean-deep dark:text-warm-white sm:text-4xl lg:text-[2.75rem]">
                    {{ $settings['section_location_title'] ?? 'Lokasi Pantai Selat Baru' }}
                </h2>
            </div>
            <div class="col-span-12 lg:col-span-5">
                <p class="text-sm leading-relaxed text-charcoal-soft dark:text-[#bac4c5] sm:text-[15px]">
                    {{ $settings['section_location_subtitle'] ?? '' }}
                </p>
            </div>
        </div>

        <div class="mt-10 grid grid-cols-12 gap-8 lg:gap-10">
            <div class="col-span-12 lg:col-span-7" data-reveal>
                <div class="border coastal-hairline bg-warm-white p-2 dark:bg-[#162024]">
                    <div class="aspect-[16/10] w-full overflow-hidden bg-sand dark:bg-[#10171a]">
                        <iframe
                            title="Peta Lokasi Pantai Selat Baru di OpenStreetMap"
                            src="{{ $osmEmbedUrl }}"
                            class="h-full w-full border-0 dark:brightness-90 dark:contrast-105"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    </div>
                    <div class="mt-2.5 flex flex-wrap items-center justify-between gap-3 px-2 py-1 text-xs">
                        <span class="font-mono text-charcoal-soft dark:text-white/65">
                            Koordinat: {{ number_format($lat, 6) }}, {{ number_format($lng, 6) }}
                        </span>
                        <a
                            href="{{ $osmExternalUrl }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-1.5 font-semibold text-ocean hover:text-turquoise dark:text-turquoise-bright"
                        >
                            <span>Buka di OpenStreetMap</span>
                            <i data-lucide="external-link" class="h-3.5 w-3.5" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-span-12 flex flex-col justify-between lg:col-span-5" data-reveal>
                <div class="divide-y coastal-hairline border-y coastal-hairline bg-warm-white px-6 dark:bg-[#162024]">
                    @foreach($contacts as $contact)
                        <div class="flex items-start gap-4 py-5">
                            <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center border coastal-hairline bg-sand/60 text-ocean dark:bg-[#1d2a2f] dark:text-turquoise-bright">
                                <i data-lucide="{{ $contact->icon ?: 'info' }}" class="h-4 w-4" aria-hidden="true"></i>
                            </span>
                            <div>
                                <p class="text-[11px] font-semibold tracking-[0.18em] uppercase text-charcoal-soft dark:text-white/60">
                                    {{ $contact->label }}
                                </p>
                                <p class="mt-1 text-sm leading-relaxed text-charcoal dark:text-[#e5e9ea]">
                                    {{ $contact->value }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(!empty($settings['location_access_note']))
                    <div class="mt-6 border border-l-2 coastal-hairline border-l-muted-green bg-warm-white p-5 dark:bg-[#162024] dark:border-l-turquoise-bright">
                        <p class="text-[11px] font-semibold tracking-[0.2em] uppercase text-muted-green dark:text-turquoise-bright">Catatan Kunjungan</p>
                        <p class="mt-2 text-xs leading-relaxed text-charcoal-soft dark:text-[#bac4c5] sm:text-sm">
                            {{ $settings['location_access_note'] }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

