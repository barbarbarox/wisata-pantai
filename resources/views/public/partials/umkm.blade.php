<section id="umkm" class="border-b coastal-hairline bg-sand/35 py-20 dark:bg-[#131c20] sm:py-28">
    <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">
        <div class="grid grid-cols-12 items-end gap-6 border-b coastal-hairline pb-8" data-reveal>
            <div class="col-span-12 lg:col-span-7">
                <p class="text-[11px] font-semibold tracking-[0.24em] uppercase text-muted-green dark:text-turquoise-bright">
                    {{ $settings['section_umkm_eyebrow'] ?? 'EKONOMI PESISIR' }}
                </p>
                <h2 class="mt-2.5 font-editorial text-3xl font-medium tracking-tight text-ocean-deep dark:text-warm-white sm:text-4xl lg:text-[2.75rem]">
                    {{ $settings['section_umkm_title'] ?? 'Pelaku UMKM dan Kuliner Lokal' }}
                </h2>
            </div>
            <div class="col-span-12 lg:col-span-5">
                <p class="text-sm leading-relaxed text-charcoal-soft dark:text-[#bac4c5] sm:text-[15px]">
                    {{ $settings['section_umkm_subtitle'] ?? '' }}
                </p>
            </div>
        </div>

        @if($umkmItems->isNotEmpty())
            <div class="mt-12 grid grid-cols-1 border-t border-l coastal-hairline bg-warm-white dark:bg-[#162024] md:grid-cols-2">
                @foreach($umkmItems as $idx => $item)
                    @php
                        $iconMap = [
                            'Kuliner Khas Pesisir' => 'utensils',
                            'Minuman Segar' => 'coffee',
                            'Olahan Ikan & Hasil Laut' => 'fish',
                        ];
                        $umkmIcon = $iconMap[$item->product_type] ?? 'shopping-bag';
                    @endphp
                    <article class="flex flex-col justify-between border-r border-b coastal-hairline p-7 sm:p-9" data-reveal>
                        <div>
                            @if($item->image_url)
                                <div class="mb-6 aspect-[4/3] overflow-hidden border coastal-hairline bg-sand dark:bg-[#10171a]">
                                    <img
                                        src="{{ $item->image_url }}"
                                        alt="{{ $item->image_alt ?: $item->business_name }}"
                                        style="object-position: {{ $item->focal_point_style }};"
                                        class="h-full w-full object-cover transition-transform duration-500 hover:scale-[1.03]"
                                        loading="lazy"
                                    >
                                </div>
                            @else
                                <div class="mb-6 flex items-center justify-between border coastal-hairline bg-sand/60 px-4 py-3.5 dark:bg-[#1c282d]">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-9 w-9 items-center justify-center border border-ocean/20 bg-warm-white text-ocean dark:border-turquoise-bright/25 dark:bg-[#121a1e] dark:text-turquoise-bright">
                                            <i data-lucide="{{ $umkmIcon }}" class="h-4 w-4" aria-hidden="true"></i>
                                        </span>
                                        <span class="text-xs font-medium text-charcoal-soft dark:text-white/75">
                                            {{ $item->product_type }}
                                        </span>
                                    </div>
                                    <span class="font-mono text-xs text-charcoal-soft dark:text-white/45">
                                        UMKM {{ str_pad((string) ($idx + 1), 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                            @endif

                            <div class="flex items-center justify-between gap-2">
                                <span class="inline-block rounded-[2px] border border-muted-green/30 bg-muted-green/10 px-2.5 py-0.5 text-[11px] font-semibold tracking-wider uppercase text-muted-green dark:border-turquoise-bright/30 dark:bg-turquoise-bright/10 dark:text-turquoise-bright">
                                    {{ $item->product_type }}
                                </span>
                                @if($item->is_featured)
                                    <span class="text-[11px] font-medium tracking-wider uppercase text-ocean dark:text-sand">Unggulan</span>
                                @endif
                            </div>

                            <h3 class="mt-4 font-editorial text-2xl font-medium text-ocean-deep dark:text-warm-white">
                                {{ $item->business_name }}
                            </h3>

                            <p class="mt-3 text-sm leading-relaxed text-charcoal-soft dark:text-[#c0c8c9]">
                                {{ $item->description }}
                            </p>
                        </div>

                        <dl class="mt-6 space-y-2 border-t coastal-hairline pt-4 text-xs">
                            @if($item->location_note)
                                <div class="flex items-start gap-2.5 text-charcoal-soft dark:text-white/75">
                                    <i data-lucide="map-pin" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-turquoise dark:text-turquoise-bright" aria-hidden="true"></i>
                                    <span>{{ $item->location_note }}</span>
                                </div>
                            @endif
                            @if($item->contact_info)
                                <div class="flex items-start gap-2.5 text-charcoal dark:text-white/90">
                                    <i data-lucide="phone" class="mt-0.5 h-3.5 w-3.5 shrink-0 text-ocean dark:text-turquoise-bright" aria-hidden="true"></i>
                                    <span>{{ $item->contact_info }}</span>
                                </div>
                            @else
                                <div class="flex items-start gap-2.5 text-charcoal-soft/80 dark:text-white/55">
                                    <i data-lucide="info" class="mt-0.5 h-3.5 w-3.5 shrink-0" aria-hidden="true"></i>
                                    <span>Kontak langsung dan foto gerai dapat dilengkapi pengelola melalui dashboard admin.</span>
                                </div>
                            @endif
                        </dl>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>

