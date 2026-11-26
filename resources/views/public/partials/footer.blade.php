@php
    $siteName = $settings['site_name'] ?? 'Pantai Selat Baru';
    $footerBg = \App\Models\SiteSetting::imageUrlFor($settings['footer_background_image'] ?? null);
@endphp

<footer class="relative overflow-hidden border-t border-white/10 bg-ocean-deep text-warm-white">
    @if($footerBg)
        <div
            class="pointer-events-none absolute inset-0 bg-cover bg-center opacity-15"
            style="background-image: url('{{ $footerBg }}');"
            aria-hidden="true"
        ></div>
    @endif

    <div class="relative z-10 mx-auto max-w-7xl px-5 py-16 sm:px-8 lg:px-10">
        <div class="grid grid-cols-12 gap-10 border-b border-white/15 pb-12">
            <div class="col-span-12 lg:col-span-5">
                <p class="font-editorial text-2xl font-medium text-warm-white sm:text-3xl">{{ $siteName }}</p>
                <p class="mt-1 text-[11px] tracking-[0.22em] uppercase text-turquoise-bright">
                    {{ $settings['site_tagline'] ?? 'Kabupaten Bengkalis, Riau' }}
                </p>
                <p class="mt-4 max-w-[44ch] text-sm leading-relaxed text-white/75">
                    {{ $settings['footer_description'] ?? '' }}
                </p>
            </div>

            <div class="col-span-6 sm:col-span-4 lg:col-span-2">
                <p class="text-[11px] font-semibold tracking-[0.2em] uppercase text-white/55">Navigasi</p>
                <ul class="mt-4 space-y-2.5 text-sm text-white/80">
                    <li><a href="#beranda" class="transition-colors hover:text-turquoise-bright">Beranda</a></li>
                    <li><a href="#tentang" class="transition-colors hover:text-turquoise-bright">Tentang</a></li>
                    <li><a href="#destinasi" class="transition-colors hover:text-turquoise-bright">Destinasi</a></li>
                    <li><a href="#aktivitas" class="transition-colors hover:text-turquoise-bright">Aktivitas</a></li>
                    <li><a href="#umkm" class="transition-colors hover:text-turquoise-bright">UMKM Lokal</a></li>
                    <li><a href="#galeri" class="transition-colors hover:text-turquoise-bright">Galeri</a></li>
                </ul>
            </div>

            <div class="col-span-6 sm:col-span-4 lg:col-span-3">
                <p class="text-[11px] font-semibold tracking-[0.2em] uppercase text-white/55">Lokasi & Kontak</p>
                <ul class="mt-4 space-y-2.5 text-sm text-white/80">
                    @foreach($contacts->take(3) as $contact)
                        <li>
                            <span class="block text-[11px] uppercase tracking-wider text-white/50">{{ $contact->label }}</span>
                            <span class="text-xs leading-relaxed text-white/85">{{ $contact->value }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-span-12 sm:col-span-4 lg:col-span-2">
                <p class="text-[11px] font-semibold tracking-[0.2em] uppercase text-white/55">Tautan & Pengelola</p>
                <ul class="mt-4 space-y-2.5 text-sm text-white/80">
                    @forelse($socialLinks as $social)
                        <li>
                            <a
                                href="{{ $social->url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 transition-colors hover:text-turquoise-bright"
                            >
                                <x-social-icon :name="$social->icon ?: $social->platform" class="h-4 w-4 shrink-0" />
                                <span>{{ $social->platform }}</span>
                            </a>
                        </li>
                    @empty
                        <li class="text-xs text-white/55">Saluran resmi dapat ditambahkan melalui panel admin.</li>
                    @endforelse
                    <li class="pt-3">
                        <a
                            href="{{ route('admin.login') }}"
                            class="inline-flex items-center gap-1.5 border border-white/25 px-3 py-1.5 text-xs font-medium text-white/90 transition-colors hover:border-turquoise-bright hover:text-turquoise-bright"
                        >
                            <span>Portal Admin</span>
                            <i data-lucide="arrow-up-right" class="h-3.5 w-3.5" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-8 flex flex-col items-start justify-between gap-3 text-xs text-white/60 sm:flex-row sm:items-center">
            <p>&copy; {{ date('Y') }} {{ $settings['footer_copyright'] ?? 'Pantai Selat Baru, Kabupaten Bengkalis.' }}</p>
            <p>Desa Selat Baru, Kecamatan Bantan, Kabupaten Bengkalis, Riau</p>
        </div>
    </div>
</footer>

