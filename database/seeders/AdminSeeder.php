<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $username = config('admin.username', 'abarox');
        $password = config('admin.password');

        if (! is_string($password) || trim($password) === '') {
            throw new RuntimeException(
                'Variabel lingkungan ADMIN_PASSWORD belum diisi. Atur ADMIN_PASSWORD pada file .env sebelum menjalankan seeder admin.'
            );
        }

        Admin::updateOrCreate(
            ['username' => $username],
            [
                'name' => 'Pengelola Pantai Selat Baru',
                'email' => null,
                'password' => Hash::make($password),
            ]
        );
    }
}
