<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Services\SiteContentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('admin.contacts.index', [
            'contacts' => Contact::ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.contacts.form', [
            'contact' => new Contact(['type' => 'info', 'icon' => 'map-pin', 'is_active' => true, 'sort_order' => Contact::max('sort_order') + 1]),
        ]);
    }

    public function store(Request $request, SiteContentService $siteContent): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['updated_by'] = Auth::guard('admin')->id();

        Contact::create($data);
        $siteContent->flushCache();

        return redirect()->route('admin.contacts.index')->with('status', 'Informasi kontak baru berhasil ditambahkan.');
    }

    public function edit(Contact $contact): View
    {
        return view('admin.contacts.form', ['contact' => $contact]);
    }

    public function update(Request $request, Contact $contact, SiteContentService $siteContent): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['is_active'] = $request->boolean('is_active');
        $data['updated_by'] = Auth::guard('admin')->id();

        $contact->update($data);
        $siteContent->flushCache();

        return redirect()->route('admin.contacts.index')->with('status', 'Informasi kontak berhasil diperbarui.');
    }

    public function destroy(Contact $contact, SiteContentService $siteContent): RedirectResponse
    {
        $contact->delete();
        $siteContent->flushCache();

        return redirect()->route('admin.contacts.index')->with('status', 'Informasi kontak berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateData(Request $request): array
    {
        return $request->validate([
            'label' => ['required', 'string', 'max:120'],
            'type' => ['required', Rule::in(['address', 'phone', 'email', 'hours', 'info'])],
            'value' => ['required', 'string', 'max:1000'],
            'icon' => ['required', Rule::in(['map-pin', 'phone', 'mail', 'clock', 'compass', 'info'])],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }
}
