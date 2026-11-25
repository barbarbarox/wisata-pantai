@php
    $siteName = $settings['site_name'] ?? 'Pantai Selat Baru';
    $siteLogo = !empty($settings['site_logo']) ? '/storage/' . ltrim($settings['site_logo'], '/') : null;
    $navLinks = [
        ['label' => 'Home', 'href' => '#beranda'],
        ['label' => 'Tentang', 'href' => '#tentang'],
        ['label' => 'Destinasi', 'href' => '#destinasi'],
        ['label' => 'Aktivitas', 'href' => '#aktivitas'],
        ['label' => 'UMKM', 'href' => '#umkm'],
        ['label' => 'Galeri', 'href' => '#galeri'],
        ['label' => 'Kontak', 'href' => '#kontak'],
    ];
@endphp

<header
    data-site-header
    class="fixed inset-x-0 top-0 z-40 border-b border-white/15 bg-gradient-to-b from-[#081c24]/70 to-transparent text-white transition-all duration-300 [&.is-scrolled]:border-charcoal/12 [&.is-scrolled]:bg-warm-white/95 [&.is-scrolled]:bg-none [&.is-scrolled]:text-charcoal [&.is-scrolled]:backdrop-blur-md dark:[&.is-scrolled]:border-white/12 dark:[&.is-scrolled]:bg-[#10171a]/95 dark:[&.is-scrolled]:text-[#f0ece3]"
>
    <div class="mx-auto flex h-18 max-w-7xl items-center justify-between px-5 sm:px-8 lg:px-10">
        <a href="#beranda" class="group flex items-center gap-3 focus:outline-none">
            @if($siteLogo)
                <img src="{{ $siteLogo }}" alt="{{ $siteName }}" class="h-9 w-9 object-contain">
            @else
                <span class="flex h-9 w-9 items-center justify-center border border-current/25 transition-colors group-hover:border-turquoise-bright">
                    <svg viewBox="0 0 28 28" fill="none" class="h-5 w-5" aria-hidden="true">
                        <path d="M3 16c3.5-2.5 6.5-2.5 10 0s6.5 2.5 12 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="square"/>
                        <path d="M5 20.5c3-1.8 5.5-1.8 8.5 0s5.5 1.8 9.5 0" stroke="currentColor" stroke-width="1.3" opacity="0.7" stroke-linecap="square"/>
                        <circle cx="19" cy="8.5" r="2.2" stroke="currentColor" stroke-width="1.4"/>
                    </svg>
                </span>
            @endif
            <div class="leading-tight">
                <span class="block font-editorial text-lg font-medium tracking-tight sm:text-xl">{{ $siteName }}</span>
                <span class="block text-[10px] font-medium tracking-[0.22em] uppercase opacity-75">Bengkalis, Riau</span>
            </div>
        </a>

        <nav class="hidden items-center gap-7 lg:flex" aria-label="Navigasi Utama">
            @foreach($navLinks as $link)
                <a
                    href="{{ $link['href'] }}"
                    class="relative py-1 text-[13px] font-medium tracking-wide opacity-85 transition-opacity hover:opacity-100 after:absolute after:inset-x-0 after:-bottom-0.5 after:h-px after:origin-left after:scale-x-0 after:bg-current after:transition-transform after:duration-300 hover:after:scale-x-100"
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="flex items-center gap-2.5">
            <button
                type="button"
                data-theme-toggle
                aria-label="Ganti Tema Terang atau Gelap"
                aria-pressed="false"
                class="inline-flex h-9 w-9 items-center justify-center border border-current/25 transition-colors hover:bg-current/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-turquoise"
            >
                <i data-lucide="moon" class="h-4 w-4 dark:hidden" aria-hidden="true"></i>
                <i data-lucide="sun" class="hidden h-4 w-4 dark:block" aria-hidden="true"></i>
            </button>

            <button
                type="button"
                data-mobile-menu-toggle
                aria-expanded="false"
                aria-controls="mobile-nav-drawer"
                aria-label="Buka Menu Navigasi"
                class="inline-flex h-9 w-9 items-center justify-center border border-current/25 transition-colors hover:bg-current/10 lg:hidden"
            >
                <i data-lucide="menu" class="h-4 w-4" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</header>

<div
    id="mobile-nav-drawer"
    data-mobile-menu
    class="fixed inset-0 z-50 hidden bg-charcoal/55 opacity-0 backdrop-blur-xs transition-opacity duration-300 lg:hidden"
    role="dialog"
    aria-modal="true"
    aria-label="Menu Navigasi Mobile"
>
    <div class="absolute inset-0" data-mobile-menu-close></div>
    <div class="relative ml-auto flex h-full w-full max-w-xs flex-col justify-between border-l border-charcoal/15 bg-warm-white p-7 text-charcoal dark:border-white/15 dark:bg-[#121a1e] dark:text-[#f0ece3]">
        <div>
            <div class="flex items-center justify-between border-b coastal-hairline pb-5">
                <div>
                    <p class="font-editorial text-xl font-medium">{{ $siteName }}</p>
                    <p class="text-[11px] tracking-[0.2em] uppercase text-charcoal-soft dark:text-white/60">Navigasi</p>
                </div>
                <button
                    type="button"
                    data-mobile-menu-close
                    aria-label="Tutup Menu"
                    class="inline-flex h-9 w-9 items-center justify-center border coastal-hairline hover:bg-sand dark:hover:bg-white/10"
                >
                    <i data-lucide="x" class="h-4 w-4"></i>
                </button>
            </div>

            <nav class="mt-6 flex flex-col divide-y coastal-hairline" aria-label="Menu Mobile">
                @foreach($navLinks as $idx => $link)
                    <a
                        href="{{ $link['href'] }}"
                        class="flex items-center justify-between py-3.5 text-sm font-medium tracking-wide transition-colors hover:text-ocean dark:hover:text-turquoise-bright"
                    >
                        <span>{{ $link['label'] }}</span>
                        <span class="text-xs font-mono opacity-45">0{{ $idx + 1 }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <div class="border-t coastal-hairline pt-5 text-xs text-charcoal-soft dark:text-white/65">
            <p class="font-medium text-charcoal dark:text-white">Desa Selat Baru, Kec. Bantan</p>
            <p class="mt-1">Kabupaten Bengkalis, Provinsi Riau</p>
        </div>
    </div>
</div>

