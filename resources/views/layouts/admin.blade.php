<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin CMS') | Pantai Selat Baru</title>

    <script>
        (function () {
            try {
                const saved = localStorage.getItem('psb-theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (saved === 'dark' || (!saved && prefersDark)) {
                    document.documentElement.classList.add('dark');
                }
            } catch (e) {}
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f5f2eb] text-charcoal dark:bg-[#0f1619] dark:text-[#f0ece3]">
    @php
        $adminUser = Auth::guard('admin')->user();
        $navGroups = [
            'Ringkasan' => [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'icon' => 'layout-dashboard'],
                ['label' => 'Pengaturan Website', 'route' => 'admin.settings.edit', 'pattern' => 'admin.settings.*', 'icon' => 'settings'],
            ],
            'Konten Halaman' => [
                ['label' => 'Hero & Banner', 'route' => 'admin.heroes.index', 'pattern' => 'admin.heroes.*', 'icon' => 'layers'],
                ['label' => 'Spot Wisata', 'route' => 'admin.destinations.index', 'pattern' => 'admin.destinations.*', 'icon' => 'map'],
                ['label' => 'Aktivitas Wisata', 'route' => 'admin.activities.index', 'pattern' => 'admin.activities.*', 'icon' => 'compass'],
                ['label' => 'UMKM Lokal', 'route' => 'admin.umkm.index', 'pattern' => 'admin.umkm.*', 'icon' => 'store'],
                ['label' => 'Galeri Foto', 'route' => 'admin.galleries.index', 'pattern' => 'admin.galleries.*', 'icon' => 'images'],
            ],
            'Koneksi & Media' => [
                ['label' => 'Informasi Kontak', 'route' => 'admin.contacts.index', 'pattern' => 'admin.contacts.*', 'icon' => 'phone'],
                ['label' => 'Media Sosial', 'route' => 'admin.social-links.index', 'pattern' => 'admin.social-links.*', 'icon' => 'share-2'],
                ['label' => 'Pustaka Media', 'route' => 'admin.media.index', 'pattern' => 'admin.media.*', 'icon' => 'folder-open'],
                ['label' => 'Akun Admin', 'route' => 'admin.profile.edit', 'pattern' => 'admin.profile.*', 'icon' => 'user'],
            ],
        ];
    @endphp

    <div data-admin-backdrop class="fixed inset-0 z-40 hidden bg-black/50 lg:hidden"></div>

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside
            data-admin-sidebar
            class="fixed inset-y-0 left-0 z-50 flex w-68 -translate-x-full flex-col justify-between border-r coastal-hairline bg-warm-white transition-transform duration-300 dark:bg-[#121c20] lg:static lg:translate-x-0"
        >
            <div>
                <div class="border-b coastal-hairline px-6 py-5">
                    <a href="{{ route('admin.dashboard') }}" class="block">
                        <span class="block text-[10px] font-semibold tracking-[0.22em] uppercase text-turquoise dark:text-turquoise-bright">Panel Pengelola</span>
                        <span class="mt-0.5 block font-editorial text-xl font-medium text-ocean-deep dark:text-warm-white">Pantai Selat Baru</span>
                    </a>
                </div>

                <nav class="space-y-6 px-4 py-6" aria-label="Menu Admin CMS">
                    @foreach($navGroups as $groupLabel => $items)
                        <div>
                            <p class="px-3 text-[10px] font-semibold tracking-[0.2em] uppercase text-charcoal-soft dark:text-white/45">
                                {{ $groupLabel }}
                            </p>
                            <ul class="mt-2 space-y-1">
                                @foreach($items as $item)
                                    @php $active = request()->routeIs($item['pattern']); @endphp
                                    <li>
                                        <a
                                            href="{{ route($item['route']) }}"
                                            class="flex items-center gap-3 rounded-[2px] px-3 py-2 text-[13px] font-medium transition-colors {{ $active ? 'bg-ocean text-warm-white dark:bg-turquoise-bright dark:text-charcoal' : 'text-charcoal-soft hover:bg-sand/70 hover:text-charcoal dark:text-white/75 dark:hover:bg-white/5 dark:hover:text-white' }}"
                                        >
                                            <i data-lucide="{{ $item['icon'] }}" class="h-4 w-4 shrink-0" aria-hidden="true"></i>
                                            <span>{{ $item['label'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </nav>
            </div>

            <div class="border-t coastal-hairline p-4">
                <div class="mb-3 flex items-center justify-between px-2">
                    <div class="min-w-0">
                        <p class="truncate text-xs font-semibold text-charcoal dark:text-white">{{ $adminUser?->name ?? 'Admin' }}</p>
                        <p class="truncate text-[11px] text-charcoal-soft dark:text-white/55">{{ '@' . ($adminUser?->username ?? 'abarox') }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="flex w-full items-center justify-center gap-2 rounded-[2px] border coastal-hairline px-3 py-2 text-xs font-semibold text-charcoal transition-colors hover:bg-sand dark:text-white/85 dark:hover:bg-white/10"
                    >
                        <i data-lucide="log-out" class="h-3.5 w-3.5" aria-hidden="true"></i>
                        <span>Keluar dari Admin</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b coastal-hairline bg-warm-white/95 px-5 backdrop-blur-sm dark:bg-[#121c20]/95 sm:px-8">
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        data-admin-sidebar-toggle
                        aria-label="Buka Navigasi Admin"
                        class="inline-flex h-9 w-9 items-center justify-center border coastal-hairline lg:hidden"
                    >
                        <i data-lucide="menu" class="h-4 w-4"></i>
                    </button>
                    <h1 class="font-editorial text-xl font-medium text-ocean-deep dark:text-warm-white sm:text-2xl">
                        @yield('page-title', 'Dashboard')
                    </h1>
                </div>

                <div class="flex items-center gap-2.5">
                    <a
                        href="{{ route('home') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-1.5 rounded-[2px] border coastal-hairline px-3 py-1.5 text-xs font-medium text-charcoal transition-colors hover:bg-sand dark:text-white/85 dark:hover:bg-white/10"
                    >
                        <span>Lihat Website</span>
                        <i data-lucide="external-link" class="h-3.5 w-3.5" aria-hidden="true"></i>
                    </a>

                    <button
                        type="button"
                        data-theme-toggle
                        aria-label="Ganti Tema"
                        class="inline-flex h-9 w-9 items-center justify-center border coastal-hairline hover:bg-sand dark:hover:bg-white/10"
                    >
                        <i data-lucide="moon" class="h-4 w-4 dark:hidden"></i>
                        <i data-lucide="sun" class="hidden h-4 w-4 dark:block"></i>
                    </button>
                </div>
            </header>

            <main class="flex-1 p-5 sm:p-8">
                @if(session('status'))
                    <div class="mb-6 flex items-center gap-3 border border-muted-green/40 bg-muted-green/10 px-4 py-3 text-sm text-muted-green dark:border-turquoise-bright/40 dark:bg-turquoise-bright/10 dark:text-turquoise-bright">
                        <i data-lucide="check" class="h-4 w-4 shrink-0"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 flex items-center gap-3 border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-700 dark:text-red-300">
                        <i data-lucide="alert-circle" class="h-4 w-4 shrink-0"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-700 dark:text-red-300">
                        <p class="font-semibold">Periksa kembali input berikut:</p>
                        <ul class="mt-1.5 list-disc pl-5 text-xs space-y-1">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
