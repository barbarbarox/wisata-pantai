<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Pengelola | Pantai Selat Baru</title>
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
<body class="min-h-screen bg-warm-white text-charcoal dark:bg-[#10171a] dark:text-[#f0ece3]">
    <div class="grid min-h-screen grid-cols-1 lg:grid-cols-12">
        <div class="relative hidden bg-ocean-deep lg:col-span-6 lg:flex lg:flex-col lg:justify-between lg:p-12">
            <img
                src="/storage/media/heroes/hero-panoramic-coastline.webp"
                alt="Pantai Selat Baru, Bengkalis"
                class="absolute inset-0 h-full w-full object-cover opacity-55"
                onerror="this.style.display='none'"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-[#081c24]/90 via-[#081c24]/45 to-[#081c24]/60"></div>

            <div class="relative z-10 flex items-center justify-between text-warm-white">
                <span class="text-xs font-semibold tracking-[0.22em] uppercase text-turquoise-bright">Sistem Pengelolaan Konten</span>
                <a href="{{ route('home') }}" class="text-xs underline underline-offset-4 hover:text-sand">Kembali ke Website</a>
            </div>

            <div class="relative z-10 max-w-md text-warm-white">
                <h1 class="font-editorial text-4xl font-medium leading-tight">Pantai Selat Baru</h1>
                <p class="mt-3 text-sm leading-relaxed text-white/80">
                    Panel administrasi terpusat untuk mengelola informasi wisata pesisir, foto galeri, spot kawasan, aktivitas, serta direktori UMKM Kabupaten Bengkalis.
                </p>
            </div>
        </div>

        <div class="flex flex-col justify-between p-6 sm:p-12 lg:col-span-6">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-medium text-charcoal-soft hover:text-ocean dark:text-white/70 dark:hover:text-turquoise-bright">
                    <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
                    <span>Kembali ke Halaman Publik</span>
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

            <div class="mx-auto w-full max-w-md py-12">
                <p class="text-[11px] font-semibold tracking-[0.22em] uppercase text-turquoise dark:text-turquoise-bright">Autentikasi Pengelola</p>
                <h2 class="mt-2 font-editorial text-3xl font-medium text-ocean-deep dark:text-warm-white">Masuk ke Dashboard CMS</h2>
                <p class="mt-2 text-sm text-charcoal-soft dark:text-white/65">
                    Gunakan akun pengelola yang telah dikonfigurasi pada sistem.
                </p>

                @if(session('status'))
                    <div class="mt-5 border border-muted-green/40 bg-muted-green/10 px-4 py-3 text-xs text-muted-green dark:text-turquoise-bright">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}" class="mt-7 space-y-5">
                    @csrf

                    <div>
                        <label for="username" class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Username</label>
                        <input
                            id="username"
                            type="text"
                            name="username"
                            value="{{ old('username') }}"
                            required
                            autofocus
                            autocomplete="username"
                            class="w-full rounded-[2px] border coastal-hairline bg-white px-4 py-3 text-sm focus:border-ocean focus:outline-none dark:bg-[#162024] dark:focus:border-turquoise-bright"
                        >
                        @error('username')
                            <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Password</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="w-full rounded-[2px] border coastal-hairline bg-white px-4 py-3 text-sm focus:border-ocean focus:outline-none dark:bg-[#162024] dark:focus:border-turquoise-bright"
                        >
                        @error('password')
                            <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="inline-flex cursor-pointer items-center gap-2 text-xs text-charcoal-soft dark:text-white/75">
                            <input type="checkbox" name="remember" value="1" class="accent-ocean dark:accent-turquoise-bright">
                            <span>Pertahankan sesi masuk</span>
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-[2px] bg-ocean px-5 py-3.5 text-sm font-semibold tracking-wide text-warm-white transition-colors hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal dark:hover:bg-white"
                    >
                        Masuk ke Panel Admin
                    </button>
                </form>
            </div>

            <p class="text-xs text-charcoal-soft dark:text-white/50">
                Pantai Selat Baru, Kecamatan Bantan, Kabupaten Bengkalis.
            </p>
        </div>
    </div>
</body>
</html>
