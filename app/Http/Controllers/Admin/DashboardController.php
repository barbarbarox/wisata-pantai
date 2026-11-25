<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Destination;
use App\Models\Gallery;
use App\Models\HeroSection;
use App\Models\Umkm;
use App\Services\SiteContentService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(SiteContentService $siteContent): View
    {
        return view('admin.dashboard', [
            'stats' => $siteContent->getDashboardStats(),
            'activeHero' => HeroSection::active()->ordered()->first(),
            'recentDestinations' => Destination::latest('updated_at')->take(4)->get(),
            'recentGalleries' => Gallery::latest('updated_at')->take(4)->get(),
            'recentActivities' => Activity::latest('updated_at')->take(3)->get(),
            'recentUmkm' => Umkm::latest('updated_at')->take(3)->get(),
        ]);
    }
}
