<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $settings['site_description'] ?? 'Profil wisata pesisir Pantai Selat Baru, Kabupaten Bengkalis, Riau.' }}">
    <title>{{ $settings['site_name'] ?? 'Pantai Selat Baru' }} | {{ $settings['site_tagline'] ?? 'Kabupaten Bengkalis, Riau' }}</title>

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
<body class="relative min-h-screen bg-warm-white text-charcoal dark:bg-[#10171a] dark:text-[#f0ece3] selection:bg-turquoise/20 selection:text-ocean dark:selection:text-turquoise-bright">
    @if(!empty($settings['website_background_image']))
        <div
            class="pointer-events-none fixed inset-0 -z-10 bg-cover bg-center opacity-[0.06] dark:opacity-[0.07]"
            style="background-image: url('/storage/{{ ltrim($settings['website_background_image'], '/') }}');"
            aria-hidden="true"
        ></div>
    @endif

    @yield('content')
</body>
</html>

