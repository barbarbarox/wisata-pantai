<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.edit', [
            'admin' => Auth::guard('admin')->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:160', Rule::unique('admins', 'email')->ignore($admin->id)],
            'current_password' => ['nullable', 'required_with:new_password', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (! empty($validated['new_password'])) {
            if (! Hash::check($validated['current_password'], $admin->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.'])->withInput();
            }
            $admin->password = $validated['new_password'];
        }

        $admin->name = $validated['name'];
        $admin->email = $validated['email'] ?? null;
        $admin->save();

        return redirect()->route('admin.profile.edit')->with('status', 'Profil akun admin berhasil diperbarui.');
    }
}
