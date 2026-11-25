<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Contact;
use App\Models\Destination;
use App\Models\Gallery;
use App\Models\HeroSection;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\Umkm;
use Illuminate\Support\Facades\Cache;

class SiteContentService
{
    private const SETTINGS_CACHE_KEY = 'site_settings.map';

    /**
     * @return array<string, ?string>
     */
    public function getSettingsMap(): array
    {
        return Cache::remember(self::SETTINGS_CACHE_KEY, 3600, function (): array {
            return SiteSetting::query()
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    public function setting(string $key, ?string $default = null): ?string
    {
        $map = $this->getSettingsMap();

        return $map[$key] ?? $default;
    }

    public function isSectionEnabled(string $sectionKey): bool
    {
        return $this->setting('section_'.$sectionKey.'_active', '1') === '1';
    }

    public function flushCache(): void
    {
        Cache::forget(self::SETTINGS_CACHE_KEY);
    }

    /**
     * @return array<string, mixed>
     */
    public function getPublicPageData(): array
    {
        $settings = $this->getSettingsMap();

        $activeHero = HeroSection::active()->ordered()->first()
            ?? HeroSection::ordered()->first();

        return [
            'settings' => $settings,
            'hero' => $activeHero,
            'destinations' => Destination::active()->ordered()->get(),
            'activities' => Activity::active()->ordered()->get(),
            'umkmItems' => Umkm::active()->ordered()->get(),
            'galleries' => Gallery::active()->ordered()->get(),
            'contacts' => Contact::active()->ordered()->get(),
            'socialLinks' => SocialLink::active()->ordered()->get(),
        ];
    }

    /**
     * @return array<string, int>
     */
    public function getDashboardStats(): array
    {
        $destinationsCount = Destination::count();
        $galleriesCount = Gallery::count();
        $umkmCount = Umkm::count();
        $activitiesCount = Activity::count();
        $heroesCount = HeroSection::count();
        $contactsCount = Contact::count();
        $socialCount = SocialLink::count();
        $settingsCount = SiteSetting::count();

        return [
            'destinations_total' => $destinationsCount,
            'destinations_active' => Destination::active()->count(),
            'galleries_total' => $galleriesCount,
            'galleries_active' => Gallery::active()->count(),
            'umkm_total' => $umkmCount,
            'umkm_active' => Umkm::active()->count(),
            'activities_total' => $activitiesCount,
            'activities_active' => Activity::active()->count(),
            'heroes_total' => $heroesCount,
            'contacts_total' => $contactsCount,
            'social_total' => $socialCount,
            'settings_total' => $settingsCount,
            'content_total' => $destinationsCount
                + $galleriesCount
                + $umkmCount
                + $activitiesCount
                + $heroesCount
                + $contactsCount
                + $socialCount,
        ];
    }
}

