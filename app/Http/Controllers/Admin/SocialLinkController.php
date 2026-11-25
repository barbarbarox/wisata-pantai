<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use App\Services\SiteContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SocialLinkController extends Controller
{
    public function index(): View
    {
        return view('admin.social-links.index', [
            'socialLinks' => SocialLink::ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.social-links.form', [
            'socialLink' => new SocialLink(['icon' => 'globe', 'is_active' => true, 'sort_order' => SocialLink::max('sort_order') + 1]),
        ]);
    }

    public function store(Request $request, SiteContentService $siteContent): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['updated_by'] = Auth::guard('admin')->id();

        SocialLink::create($data);
        $siteContent->flushCache();

        return redirect()->route('admin.social-links.index')->with('status', 'Tautan media sosial berhasil ditambahkan.');
    }

    public function edit(SocialLink $socialLink): View
    {
        return view('admin.social-links.form', ['socialLink' => $socialLink]);
    }

    public function update(Request $request, SocialLink $socialLink, SiteContentService $siteContent): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['updated_by'] = Auth::guard('admin')->id();

        $socialLink->update($data);
        $siteContent->flushCache();

        return redirect()->route('admin.social-links.index')->with('status', 'Tautan media sosial berhasil diperbarui.');
    }

    public function destroy(SocialLink $socialLink, SiteContentService $siteContent): RedirectResponse
    {
        $socialLink->delete();
        $siteContent->flushCache();

        return redirect()->route('admin.social-links.index')->with('status', 'Tautan media sosial berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateData(Request $request): array
    {
        return $request->validate([
            'platform' => ['required', 'string', 'max:80'],
            'label' => ['required', 'string', 'max:120'],
            'url' => ['required', 'url:http,https', 'max:255'],
            'icon' => ['required', Rule::in(['instagram', 'facebook', 'youtube', 'globe', 'share-2'])],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }
}
