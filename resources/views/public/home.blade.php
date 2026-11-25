@extends('layouts.public')

@section('content')
    @include('public.partials.navbar')

    <main>
        @include('public.partials.hero')

        @if(($settings['section_about_active'] ?? '1') === '1')
            @include('public.partials.about')
        @endif

        @if(($settings['section_destinations_active'] ?? '1') === '1')
            @include('public.partials.destinations')
        @endif

        @include('public.partials.banner')

        @if(($settings['section_activities_active'] ?? '1') === '1')
            @include('public.partials.activities')
        @endif

        @if(($settings['section_umkm_active'] ?? '1') === '1')
            @include('public.partials.umkm')
        @endif

        @if(($settings['section_gallery_active'] ?? '1') === '1')
            @include('public.partials.gallery')
        @endif

        @if(($settings['section_location_active'] ?? '1') === '1')
            @include('public.partials.location')
        @endif
    </main>

    @include('public.partials.footer')
@endsection

