<?php

namespace App\Http\Controllers;

use App\Services\SiteContentService;
use Illuminate\View\View;

class PublicSiteController extends Controller
{
    public function index(SiteContentService $siteContent): View
    {
        return view('public.home', $siteContent->getPublicPageData());
    }
}
