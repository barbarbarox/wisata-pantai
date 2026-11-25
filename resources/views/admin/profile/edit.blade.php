@extends('layouts.admin')

@section('title', 'Akun Admin')
@section('page-title', 'Profil & Keamanan Akun Admin')

@section('content')
    <form method="POST" action="{{ route('admin.profile.update') }}" class="max-w-2xl space-y-6 border coastal-hairline bg-warm-white p-6 dark:bg-[#141f24] sm:p-8">
        @csrf
        @method('PUT')

        <div>
            <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Username</label>
            <input type="text" value="{{ $admin->username }}" disabled class="w-full cursor-not-allowed rounded-[2px] border coastal-hairline bg-sand/50 px-3.5 py-2.5 text-sm opacity-75 dark:bg-[#10171a]">
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Nama Pengelola</label>
                <input type="text" name="name" value="{{ old('name', $admin->name) }}" required class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
            <div>
                <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Email (Opsional)</label>
                <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
            </div>
        </div>

        <div class="border-t coastal-hairline pt-6">
            <h2 class="font-editorial text-xl font-medium">Ubah Password (Opsional)</h2>
            <p class="mt-1 text-xs text-charcoal-soft dark:text-white/60">Biarkan kosong jika tidak ingin mengganti password saat ini.</p>

            <div class="mt-4 space-y-4">
                <div>
                    <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Password Saat Ini</label>
                    <input type="password" name="current_password" class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Password Baru</label>
                        <input type="password" name="new_password" class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
                    </div>
                    <div>
                        <label class="mb-1.5 block text-xs font-semibold tracking-wider uppercase">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="w-full rounded-[2px] border coastal-hairline bg-white px-3.5 py-2.5 text-sm dark:bg-[#10171a]">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit" class="rounded-[2px] bg-ocean px-6 py-2.5 text-xs font-semibold text-warm-white hover:bg-ocean-deep dark:bg-turquoise-bright dark:text-charcoal">
                Perbarui Profil
            </button>
        </div>
    </form>
@endsection

