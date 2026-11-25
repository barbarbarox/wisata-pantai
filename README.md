# Pantai Selat Baru — Website Profil Wisata & Content Management System

Website profil, informasi wisata pesisir, serta sistem manajemen konten (CMS) untuk destinasi **Pantai Selat Baru** di Desa Selat Baru, Kecamatan Bantan, Kabupaten Bengkalis, Provinsi Riau.

Aplikasi ini dirancang dengan pendekatan editorial modern pesisir (*Coastal Monograph*) yang menggabungkan halaman publik responsif (termasuk dukungan Mode Terang dan Mode Gelap) dengan panel administrasi terintegrasi pada rute `/admin` untuk mengelola seluruh konten dan gambar secara dinamis tanpa menyentuh kode program.

---

## 1. Gambaran Umum Proyek

- **Nama Proyek**: Pantai Selat Baru Tourism Website & CMS
- **Tujuan**:
  1. Memperkenalkan profil geografis dan daya tarik pesisir Pantai Selat Baru kepada wisatawan dan masyarakat umum.
  2. Menyajikan fotografi pantai beresolusi tinggi dengan pemuatan cepat (format WebP).
  3. Mempromosikan spot kawasan pantai, aktivitas pengunjung, dan direktori pelaku UMKM lokal.
  4. Menyediakan CMS berbasis web agar pengelola dapat mengubah teks, foto, latar bagian, koordinat peta, informasi kontak, serta visibilitas setiap bagian secara langsung.
- **Teknologi Inti**: Laravel 13, PHP 8.3, MySQL 8.0, Blade, Tailwind CSS v4, JavaScript, Vite, Lucide Icons, Nginx, dan Docker Compose.

---

## 2. Fitur Utama

### Halaman Publik (`/`)
- **Navigasi Responsif & Toggle Tema**: Navigasi sticky dengan penunjuk seksi aktif, menu drawer khusus perangkat mobile, serta tombol ganti *Light Mode* dan *Dark Mode* yang menyimpan preferensi pengguna di `localStorage`.
- **Hero Section Dinamis**: Latar fotografi pantai lebar penuh dengan efek paralaks ringan (menghormati `prefers-reduced-motion`), *eyebrow*, judul utama, deskripsi singkat, tombol CTA utama dan sekunder, serta ringkasan wilayah geografis.
- **Bagian Tentang Pantai**: Tata letak editorial asimetris dua kolom dengan komposisi foto ganda dan catatan geografis kawasan.
- **Jelajah Spot Wisata (`#destinasi`)**: Menampilkan spot unggulan secara horizontal diikuti kisi asimetris spot pantai, lengkap dengan modal detail interaktif (*Baca Catatan Spot*).
- **Banner Jeda Editorial**: Pemisah visual dengan kutipan pesisir yang dapat disunting melalui pengaturan website.
- **Aktivitas Wisata (`#aktivitas`)**: Daftar bernomor kegiatan wisata pesisir beserta kategori dan waktu kunjungan terbaik.
- **UMKM Lokal (`#umkm`)**: Direktori terstruktur usaha mikro dan kuliner pesisir dengan dukungan unggah foto gerai, jenis produk, deskripsi, lokasi, dan kontak resmi.
- **Galeri Foto & Lightbox (`#galeri`)**: Kisi foto dengan variasi rasio (`wide`, `portrait`, `square`, `landscape`), filter kategori langsung di browser, serta *lightbox* berfitur navigasi keyboard (`Esc`, panah kiri/kanan).
- **Peta Lokasi & Kontak (`#kontak`)**: Peta interaktif berbasis OpenStreetMap yang titik koordinatnya mengikuti pengaturan admin, dilengkapi daftar informasi kontak kawasan.
- **Footer**: Identitas situs, navigasi cepat, ringkasan kontak, tautan media sosial aktif, akses menuju portal admin, dan hak cipta dinamis.

### Panel Administrasi CMS (`/admin`)
- **Autentikasi Terproteksi**: Login/logout berbasis session guard khusus `admin`, password ter-hash, perlindungan CSRF, dan proteksi middleware `admin.auth`.
- **Dashboard Ringkasan**: Statistik jumlah spot wisata, galeri foto, UMKM, aktivitas, total konten, pratinjau hero aktif, serta daftar pembaruan terakhir.
- **Manajemen Hero & Banner**: Menambah variasi hero, mengaktifkan hero tertentu dalam satu klik, mengubah gambar latar, *focal point*, teks, dan CTA.
- **CRUD Konten Lengkap**: Pengelolaan penuh (tambah, ubah, hapus, urutkan, aktif/nonaktif, tandai unggulan) untuk Spot Wisata, Aktivitas, UMKM, Galeri Foto, Informasi Kontak, dan Media Sosial.
- **Pengaturan Website Terpusat**: Mengedit nama situs, deskripsi SEO, logo, konten bagian Tentang, latar belakang website/banner/footer, koordinat OpenStreetMap, teks footer, serta sakelar aktif/nonaktif per section.
- **Pustaka & Manajemen Gambar**: Unggah gambar JPG/PNG/WebP (maksimal 5 MB), pratinjau sebelum simpan, pemilih gambar dari pustaka media, pengaturan *focal point*, serta pembersihan otomatis file lama saat gambar diganti atau dihapus (hanya menghapus file di bawah direktori media yang dikelola aplikasi dan tidak sedang dipakai konten lain).

---

## 3. Tumpukan Teknologi (Technology Stack)

| Teknologi | Peran dalam Sistem |
| --- | --- |
| **Laravel 13** | Kerangka backend MVC, routing, autentikasi session, Eloquent ORM, migrasi, seeder, dan validasi request. |
| **PHP 8.3 (FPM)** | Runtime server aplikasi Laravel dengan ekstensi GD (WebP/JPEG/PNG), PDO MySQL, Mbstring, Intl, dan OPcache. |
| **MySQL 8.0** | Penyimpanan database relasional untuk seluruh data CMS, sesi pengguna, dan cache. |
| **Blade** | Mesin templating sisi server untuk halaman publik editorial maupun antarmuka admin. |
| **Tailwind CSS v4** | Penyusunan tata letak responsif, sistem warna pesisir, dan dukungan varian `dark:`. |
| **JavaScript & Vite** | Interaksi sisi klien (tema, modal spot, filter galeri, lightbox, pratinjau upload) serta bundling aset produksi termasuk font lokal (`Newsreader` dan `Plus Jakarta Sans`) dan ikon **Lucide**. |
| **Nginx 1.27** | Web server reverse proxy menuju PHP-FPM dan penyaji file statis (`/build` dan `/storage`). |
| **Docker & Docker Compose** | Orkestrasi tiga layanan terisolasi (`app`, `nginx`, `db`) dengan persistensi volume database dan media unggahan. |

---

## 4. Struktur Proyek

```text
.
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/               # Auth, Dashboard, Settings, Hero, Destination, Activity, Umkm, Gallery, Contact, SocialLink, Media, Profile
│   │   │   └── PublicSiteController.php
│   │   └── Middleware/              # AdminAuthenticate, AdminGuest
│   ├── Models/                      # Admin, SiteSetting, HeroSection, Destination, Activity, Umkm, Gallery, Contact, SocialLink + Concerns
│   └── Services/                    # MediaService, SiteContentService
├── bootstrap/
├── config/
│   ├── admin.php                    # Konfigurasi username/password seeder admin & batas upload
│   ├── auth.php                     # Guard & provider khusus 'admin'
│   └── ...
├── database/
│   ├── migrations/                  # 9 tabel domain CMS + tabel sistem Laravel
│   └── seeders/                     # AdminSeeder, SiteContentSeeder, DatabaseSeeder
├── docker/
│   ├── entrypoint.sh                # Sinkronisasi public/build, symlink storage, permission runtime
│   ├── nginx/default.conf           # Konfigurasi Virtual Host Nginx
│   └── php/uploads.ini              # Batas ukuran upload PHP-FPM (10M / 12M)
├── docs/
│   └── aset-visual-pending.md       # Daftar & prompt individual aset visual lanjutan
├── public/
├── resources/
│   ├── css/app.css                  # Tema Tailwind CSS v4 & tipografi editorial
│   ├── js/app.js                    # Modul interaksi publik & admin + Lucide icons
│   ├── seed-media/                  # 7 aset foto WebP hasil generasi AI untuk seeder awal
│   └── views/
│       ├── admin/                   # Tampilan login, dashboard, CRUD, media, pengaturan, profil
│       ├── components/              # Komponen Blade (image-field, social-icon)
│       ├── layouts/                 # Layout publik & layout admin
│       └── public/                  # Homepage & partial tiap bagian halaman
├── routes/web.php                   # Definisi rute publik & grup rute /admin
├── storage/
├── tests/Feature/                   # Pengujian otomatis PHPUnit
├── .dockerignore
├── .env.example
├── .gitignore
├── Dockerfile
├── docker-compose.yml
├── laporan-pembuatan.md
└── README.md
```

---

## 5. Prasyarat (Prerequisites)

Pastikan mesin tujuan memiliki perangkat lunak berikut:
- **Docker Engine** (versi 24+ direkomendasikan)
- **Docker Compose** (`docker compose` plugin v2+)
- **Git**
- **Browser modern** (Chrome, Firefox, Edge, atau Safari)

*Catatan: PHP, Composer, Node.js, dan MySQL **tidak wajib** terpasang di host karena `Dockerfile` sudah membangun dependensi PHP dan aset Vite di dalam container.*

---

## 6. Panduan Instalasi & Menjalankan Aplikasi

1. **Clone repository**:
   ```bash
   git clone https://github.com/barbarbarox/wisata-pantai.git
   cd wisata-pantai
   ```

2. **Buat file konfigurasi lingkungan**:
   ```bash
   cp .env.example .env
   ```

3. **Lengkapi variabel wajib pada `.env`**:
   Buka file `.env` dan isi nilai sensitif yang masih kosong (jangan biarkan kosong sebelum menjalankan Docker):
   - `APP_NAME`: Nama aplikasi (`"Pantai Selat Baru"`)
   - `APP_URL`: Alamat akses publik (misal `http://localhost:8000`)
   - `APP_PORT`: Port host untuk Nginx (bawaan `8000`)
   - `DB_CONNECTION`: `mysql`
   - `DB_HOST`: `db` (harus sama dengan nama service database di `docker-compose.yml`)
   - `DB_PORT`: `3306`
   - `DB_DATABASE`: `pantai_selat_baru`
   - `DB_USERNAME`: `abarox`
   - `DB_PASSWORD`: Password database untuk user `abarox` (isi dengan password kuat)
   - `DB_ROOT_PASSWORD`: Password root MySQL container (isi dengan password kuat)
   - `ADMIN_USERNAME`: Username akun admin awal (`abarox`)
   - `ADMIN_PASSWORD`: Password akun admin awal (isi dengan password kuat minimal 8 karakter)

4. **Build image dan jalankan seluruh container**:
   ```bash
   docker compose up -d --build
   ```

5. **Generate Application Key Laravel**:
   ```bash
   docker compose exec app php artisan key:generate
   ```

6. **Jalankan migrasi database dan pengisian data awal (seeder)**:
   ```bash
   docker compose exec app php artisan migrate --seed
   ```
   Perintah ini akan membuat seluruh tabel di MySQL, menyalin aset gambar awal dari `resources/seed-media/` ke `storage/app/public/media/`, mengisi konten awal Pantai Selat Baru, serta membuat akun admin berdasarkan `ADMIN_USERNAME` dan `ADMIN_PASSWORD` di `.env`.

7. **Verifikasi izin akses storage (opsional jika diperlukan)**:
   Entrypoint container sudah mengatur kepemilikan `storage/` dan `bootstrap/cache/` ke `www-data`. Jika sewaktu-waktu terjadi masalah penulisan file:
   ```bash
   docker compose exec app chown -R www-data:www-data storage bootstrap/cache
   ```

---

## 7. Mengakses Aplikasi

- **Website Publik**: `http://localhost:8000` (atau sesuai `APP_PORT` pada `.env`)
- **Dashboard Admin CMS**: `http://localhost:8000/admin`
- **Halaman Login Admin**: `http://localhost:8000/admin/login`

Akun admin awal dibuat otomatis saat menjalankan `php artisan migrate --seed` oleh `Database\Seeders\AdminSeeder` menggunakan nilai `ADMIN_USERNAME` (bawaan: `abarox`) dan `ADMIN_PASSWORD` dari file `.env`. Password disimpan dalam bentuk hash aman di tabel `admins` dan tidak pernah disimpan dalam bentuk teks biasa maupun dicantumkan di kode sumber.

---

## 8. Perintah Docker Penting

| Perintah | Fungsi dan Dampak |
| --- | --- |
| `docker compose up -d` | Menyalakan container di latar belakang tanpa rebuild image. |
| `docker compose up -d --build` | Membangun ulang image aplikasi (`Dockerfile`) dan menyalakan seluruh layanan. |
| `docker compose down` | Menghentikan dan menghapus container serta jaringan, **tanpa** menghapus volume database maupun file upload. |
| `docker compose down -v` | **PERINGATAN**: Menghapus seluruh container **beserta volume persisten** (`db_data`, `storage_public`, `web_public`). Seluruh data database dan gambar yang pernah diunggah akan hilang permanen. |
| `docker compose restart` | Memulai ulang seluruh layanan container. |
| `docker compose ps` | Memeriksa status dan port container yang sedang berjalan. |
| `docker compose logs -f` | Memantau output log gabungan dari `app`, `nginx`, dan `db` secara langsung. |
| `docker compose exec app php artisan migrate` | Menjalankan migrasi database baru yang belum tereksekusi. |
| `docker compose exec app php artisan optimize:clear` | Membersihkan cache konfigurasi, route, view, dan cache aplikasi Laravel. |

---

## 9. Manajemen Database

- **Mesin Database**: MySQL `8.0` pada service `db` (jaringan internal Docker `coastal_net`).
- **Koneksi Aplikasi**: `DB_CONNECTION=mysql`, `DB_HOST=db`, `DB_PORT=3306`.
- **Daftar Tabel Utama**: `admins`, `site_settings`, `hero_sections`, `destinations`, `activities`, `umkm`, `galleries`, `contacts`, dan `social_links`.
- **Persistensi Data**: Data MySQL disimpan pada volume Docker bernama `db_data` (`/var/lib/mysql`), sedangkan file media unggahan disimpan pada volume `storage_public` (`/var/www/html/storage/app/public`).
- **Menjalankan ulang migrasi dan data awal**:
  Jika perlu mengulang struktur database dari awal pada environment pengembangan (menghapus seluruh isi tabel):
  ```bash
  docker compose exec app php artisan migrate:fresh --seed
  ```

---

## 10. Panduan Penggunaan Admin CMS

1. **Masuk ke Panel**: Akses `/admin/login`, masukkan `username` dan `password` yang telah diatur pada `.env`.
2. **Mengedit Informasi Website & Section**: Buka menu **Pengaturan Website** (`/admin/settings`) untuk mengubah nama situs, deskripsi, bagian Tentang, banner jeda editorial, koordinat peta OpenStreetMap, latar belakang website/footer, serta menyalakan/mematikan section tertentu.
3. **Mengganti Hero Background**: Buka menu **Hero & Banner** (`/admin/heroes`), pilih variasi hero lalu klik **Jadikan Aktif**, atau klik **Edit** untuk mengunggah gambar baru dan mengubah teks CTA.
4. **Mengelola Spot Wisata, Aktivitas, dan UMKM**: Gunakan menu masing-masing di sidebar untuk menambah data, mengatur urutan (`sort_order`), mengunggah/mengganti/menghapus foto, memilih titik fokus gambar (*focal point*), dan mengatur status aktif/unggulan.
5. **Mengelola Galeri & Pustaka Media**:
   - Di menu **Galeri Foto** (`/admin/galleries`), atur kategori, keterangan foto, urutan, dan rasio grid (`wide`, `portrait`, `square`, `landscape`).
   - Di menu **Pustaka Media** (`/admin/media`), Anda dapat mengunggah aset gambar mandiri, memeriksa di konten mana gambar digunakan, serta menghapus file yang sudah tidak terpakai.

---

## 11. Troubleshooting

- **Container gagal berjalan karena variabel environment kosong**:
  Pastikan `DB_PASSWORD`, `DB_ROOT_PASSWORD`, dan `ADMIN_PASSWORD` pada `.env` sudah terisi sebelum menjalankan `docker compose up -d --build`.
- **Database connection refused saat migrasi**:
  Tunggu beberapa detik hingga status container `pantai_selat_baru_db` menjadi `healthy` (cek via `docker compose ps`) sebelum menjalankan `php artisan migrate --seed`.
- **Port `8000` atau `3307` sudah digunakan di host**:
  Ubah nilai `APP_PORT` (misal ke `8085`) atau `DB_FORWARD_PORT` (misal ke `3308`) di file `.env`, lalu jalankan ulang `docker compose up -d`.
- **Permission denied pada `storage/` atau `.env`**:
  Jalankan `docker compose exec app chown -R www-data:www-data storage bootstrap/cache`. Pastikan direktori kerja `/var/www/html` tidak diubah ke mode `1777`.
- **Gambar tidak muncul di halaman publik**:
  Pastikan symlink storage tersedia dan Nginx memiliki mount volume `storage_public`. Anda dapat memverifikasi dengan `docker compose exec app ls -la public/storage storage/app/public/media`.
- **Vite manifest tidak ditemukan**:
  Image `app` membangun aset melalui tahap multi-stage Vite dan menyalinnya ke volume `web_public` melalui `docker/entrypoint.sh`. Jalankan `docker compose up -d --build` jika ada pembaruan aset frontend.

---

## 12. Panduan Pengembangan Lanjutan

Untuk pengembangan fitur baru atau pengujian:
- **Menjalankan perintah Artisan di dalam container**:
  ```bash
  docker compose exec app php artisan <perintah>
  ```
- **Menginstal paket Composer (di lingkungan lokal atau rebuild image)**:
  ```bash
  composer require <nama-paket>
  docker compose up -d --build
  ```
- **Mengembangkan aset frontend dengan Vite (di host dengan PHP/Node terpasang)**:
  ```bash
  npm install
  npm run dev
  ```
  Setelah selesai mengubah CSS/JS/Blade, build ulang container dengan `docker compose up -d --build`.
- **Menjalankan pengujian otomatis PHPUnit**:
  ```bash
  php artisan test
  ```

---

## 13. Catatan Keamanan

- **Jangan pernah mengunggah file `.env`** ke repository Git. Pastikan `.env` tetap terdaftar pada `.gitignore`.
- Gunakan password yang kuat untuk `DB_PASSWORD`, `DB_ROOT_PASSWORD`, dan `ADMIN_PASSWORD`.
- Seluruh rute `/admin/*` (kecuali `/admin/login`) dilindungi middleware `admin.auth` serta rate limiting pada login (`throttle:10,1`).
- Seluruh unggahan gambar divalidasi hanya untuk format `jpg`, `jpeg`, `png`, dan `webp` dengan batas ukuran `5120 KB`, serta disimpan dengan nama UUID acak di luar eksekusi PHP.
- Penghapusan gambar melalui `MediaService` hanya diizinkan pada berkas di dalam direktori terkelola `media/` yang sudah tidak dirujuk oleh konten aktif mana pun.

---

## 14. Lisensi dan Atribusi Aset

- **Kode Aplikasi**: Dibangun menggunakan kerangka kerja [Laravel](https://laravel.com) (lisensi MIT) dan ikon dari [Lucide](https://lucide.dev) (lisensi ISC).
- **Peta Lokasi**: Menggunakan embed peta interaktif dari [OpenStreetMap](https://www.openstreetmap.org) (kontributor OpenStreetMap, ODbL).
- **Aset Fotografi Awal**: 7 foto pesisir Pantai Selat Baru pada `resources/seed-media/` dihasilkan khusus menggunakan generator gambar AI selama tahap pengembangan. Daftar 15 aset visual lanjutan beserta prompt individualnya tersedia di [docs/aset-visual-pending.md](file:///home/abarox/Desktop/tes/docs/aset-visual-pending.md) untuk digenerate atau diunggah melalui Admin CMS oleh pengelola.
