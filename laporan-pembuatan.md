# Laporan Pembuatan Proyek Website Pantai Selat Baru

Dokumen ini mencatat secara kronologis dan faktual seluruh proses teknis pembangunan website profil, promosi wisata daerah, serta sistem manajemen konten (CMS) **Pantai Selat Baru** di Kabupaten Bengkalis, Provinsi Riau. Seluruh perintah terminal yang tercantum merupakan perintah yang benar-benar dijalankan selama pengembangan beserta penjelasan fungsi, parameter, dan hasilnya.

---

## 1. Pendahuluan

### 1.1 Latar Belakang
Pantai Selat Baru merupakan salah satu destinasi wisata pesisir di Desa Selat Baru, Kecamatan Bantan, Kabupaten Bengkalis, Provinsi Riau, yang berhadapan langsung dengan perairan Selat Malaka. Untuk menyajikan informasi kawasan yang terstruktur, terpercaya, dan dapat diperbarui sewaktu-waktu oleh pengelola wisata daerah, diperlukan sebuah aplikasi web yang memadukan tampilan publik bergaya editorial modern dengan Content Management System (CMS) berbasis database.

### 1.2 Tujuan Proyek
1. Memperkenalkan profil geografis, bentang pantai, spot menarik, aktivitas pengunjung, dan pelaku UMKM sekitar Pantai Selat Baru.
2. Menyajikan aset fotografi pesisir berkualitas tinggi dengan format teroptimasi untuk kinerja web.
3. Memberikan kontrol penuh kepada pengelola melalui panel `/admin` untuk mengatur teks, gambar, tata letak bagian, koordinat peta, kontak, dan media sosial tanpa mengubah kode sumber.
4. Mengemas aplikasi secara portabel menggunakan Docker, Nginx, dan MySQL dengan persistensi volume.

### 1.3 Gambaran Umum Aplikasi
Aplikasi dibangun menggunakan arsitektur monolitik **Laravel 13** di atas **PHP 8.3 FPM**, disajikan melalui **Nginx**, menyimpan data pada **MySQL 8.0**, dan memaketkan antarmuka **Tailwind CSS v4** serta **JavaScript** (termasuk **Lucide Icons** dan font lokal) menggunakan **Vite**.

---

## 2. Analisis Kebutuhan

### 2.1 Kebutuhan Fungsional
- **Sisi Publik (`/`)**: Navigasi responsif dengan pemilih tema terang/gelap, bagian Hero dinamis, Pengantar (Tentang Pantai), Jelajah Spot Wisata dengan modal detail, Banner Jeda Editorial, Aktivitas Wisata, Direktori UMKM Lokal, Galeri Foto dengan filter kategori dan lightbox, Peta OpenStreetMap, serta Footer.
- **Sisi Admin CMS (`/admin`)**: Halaman login/logout berbasis session guard terpisah, dashboard ringkasan konten, pengaturan website dan sakelar visibilitas section, manajemen variasi Hero, CRUD Spot Wisata, CRUD Aktivitas, CRUD UMKM, CRUD Galeri Foto, CRUD Informasi Kontak, CRUD Media Sosial, Pustaka Media terpusat, serta manajemen profil dan password admin.

### 2.2 Kebutuhan Nonfungsional
- Validasi input sisi server pada seluruh formulir dan unggahan gambar (`jpg`, `jpeg`, `png`, `webp`, batas 5 MB).
- Perlindungan CSRF, *mass assignment protection* (`$fillable`), dan pembatasan rute melalui middleware `admin.auth`.
- Penghormatan terhadap `prefers-reduced-motion` dan konsistensi kontras pada Light Mode maupun Dark Mode.
- Pemisahan kredensial sensitif menggunakan `.env` dan `.env.example`.

### 2.3 Teknologi yang Digunakan dan Alasan Pemilihan
- **Laravel 13 & PHP 8.3**: Memberikan struktur MVC bersih, migrasi database, validasi kuat, dan pengelolaan filesystem terstandar.
- **MySQL 8.0**: Database relasional yang andal untuk data terstruktur CMS dan session database.
- **Tailwind CSS v4 & Vite**: Mempercepat penyusunan sistem desain editorial berbasis token warna pantai serta kompilasi font dan ikon secara lokal.
- **Docker Compose & Nginx**: Menjamin seluruh layanan (`app`, `nginx`, `db`) berjalan seragam di lingkungan mana pun.

---

## 3. Persiapan Environment

Pemeriksaan awal dilakukan pada direktori kerja `/home/abarox/Desktop/tes` untuk mengetahui isi folder, versi tools host, port yang telah terpakai, serta konfigurasi Git dan GitHub CLI.

```bash
ls -la /home/abarox/Desktop/tes && echo "---TOOLS---" && which docker git php composer node npm python3 gh 2>&1 || true && echo "---DOCKER---" && docker --version && docker compose version && echo "---PORTS---" && ss -tlnp 2>/dev/null || netstat -tlnp 2>/dev/null || true && echo "---GIT_AUTH---" && git config --list && (gh auth status 2>&1 || true)
```
- **Fungsi perintah**: Memeriksa kesiapan direktori kerja, ketersediaan biner sistem, versi Docker/Compose, daftar port TCP aktif, dan status autentikasi akun GitHub.
- **Parameter penting**: `ss -tlnp` menampilkan socket TCP yang sedang mendengarkan (*LISTEN*) agar konfigurasi port Docker tidak bertabrakan dengan layanan host.
- **Hasil**: Direktori kerja kosong; Docker `29.9.3` dan Docker Compose `v5.7.0` tersedia; port `80`, `8080`, dan `3306` di host sedang digunakan oleh layanan lain, sehingga port host aplikasi direncanakan memakai `8000` (Nginx) dan `3307` (MySQL opsional localhost); GitHub CLI telah terautentikasi pada akun `barbarbarox`.

Pemeriksaan lanjutan dilakukan untuk mengecek versi PHP, Composer, Node.js, npm, status repository GitHub tujuan, dan ketersediaan pustaka pengolah gambar lokal:

```bash
php -v && composer --version && node -v && npm -v && echo "---DOCKER_PS---" && docker ps && echo "---REMOTE_REPO---" && git ls-remote https://github.com/barbarbarox/wisata-pantai.git 2>&1 || true && echo "---GH_REPO---" && gh repo view barbarbarox/wisata-pantai 2>&1 || true && echo "---IMG_TOOLS---" && python3 -c "import PIL; print('Pillow:', PIL.__version__)" 2>&1 || true && which cwebp convert magick optipng jpegoptim 2>&1 || true
```
- **Fungsi perintah**: Memverifikasi kompatibilitas versi runtime serta memastikan apakah repository tujuan `barbarbarbarox/wisata-pantai` sudah memiliki commit.
- **Hasil**: PHP `8.3.6`, Composer `2.9.7`, Node `v24.22.2`, npm `11.19.1`, Pillow `12.2.0`, dan ImageMagick (`/usr/bin/convert`) tersedia. Repository `barbarbarox/wisata-pantai` terverifikasi ada dan masih kosong.

---

## 4. Inisialisasi Proyek Laravel

Pembuatan proyek Laravel baru dilakukan langsung pada direktori kerja:

```bash
composer create-project laravel/laravel /home/abarox/Desktop/tes --no-interaction && cd /home/abarox/Desktop/tes && php artisan --version
```
- **Fungsi perintah**: Mengunduh kerangka kerja Laravel beserta dependensi PHP-nya, membuat file konfigurasi awal, menginisialisasi `.env` sementara, dan mencetak versi Laravel terpasang.
- **Parameter penting**: `--no-interaction` menjalankan proses instalasi tanpa prompt interaktif.
- **Hasil**: Berhasil menginstal **Laravel Framework 13.44.1** di `/home/abarox/Desktop/tes`.

Selanjutnya dilakukan instalasi paket frontend JavaScript, ikon Lucide, serta paket font lokal `@fontsource-variable/newsreader` dan `@fontsource-variable/plus-jakarta-sans`:

```bash
cd /home/abarox/Desktop/tes && npm install && npm install lucide
```
```bash
cd /home/abarox/Desktop/tes && php artisan route:list && npm install @fontsource-variable/newsreader @fontsource-variable/plus-jakarta-sans
```
- **Fungsi perintah**: Memasang dependensi Tailwind CSS v4, Vite, ikon Lucide, dan font editorial lokal agar aset font dibundel langsung oleh Vite tanpa ketergantungan jaringan eksternal saat runtime.
- **Hasil**: Seluruh paket JS dan font terpasang di `node_modules/`.

---

## 5. Konfigurasi Docker

Arsitektur Docker didefinisikan melalui file berikut:
- `Dockerfile`: Multi-stage build menggunakan `node:22-alpine` untuk `npm ci && npm run build`, dilanjutkan `php:8.3-fpm-alpine` dengan ekstensi PHP (`bcmath`, `exif`, `gd` dengan dukungan FreeType/JPEG/WebP, `intl`, `mbstring`, `opcache`, `pdo_mysql`, `zip`), dependensi Composer (`--no-dev --optimize-autoloader`), serta penyalinan hasil build frontend ke `/opt/app-public`.
- `docker-compose.yml`: Mendefinisikan tiga service (`app`, `nginx`, `db`) pada jaringan bridge `coastal_net` dengan volume persisten `db_data` (MySQL `/var/lib/mysql`), `storage_public` (upload & media seeder `/var/www/html/storage/app/public`), dan `web_public` (aset publik & manifest Vite). Port Nginx dipetakan ke `${APP_PORT:-8000}:80` dan port MySQL localhost ke `127.0.0.1:${DB_FORWARD_PORT:-3307}:3306`.
- `docker/nginx/default.conf`: Mengonfigurasi virtual host Nginx untuk meneruskan permintaan PHP ke `app:9000` dan menyajikan `/storage/` serta `/build/` dengan batas body upload `12M`.
- `docker/php/uploads.ini`: Mengatur `upload_max_filesize = 10M` dan `post_max_size = 12M`.
- `docker/entrypoint.sh`: Menyegarkan aset `/opt/app-public` ke volume `web_public`, membuat symlink `public/storage`, membuat `storage/logs/laravel.log`, serta menetapkan kepemilikan `storage` dan `bootstrap/cache` ke `www-data`.

Build container dan startup awal dijalankan dengan:
```bash
docker compose up -d --build
```
- **Fungsi perintah**: Membangun image `tes-app` dari `Dockerfile`, mengunduh image `nginx:1.27-alpine` serta `mysql:8.0`, membuat jaringan dan volume persisten, lalu menyalakan seluruh container di latar belakang.
- **Kendala yang ditemukan dan diperbaiki**: Saat pertama kali menjalankan `docker compose exec -T app php artisan key:generate --force`, muncul error `Permission denied` pada penulisan `/var/www/html/.env`. Pemeriksaan kernel dan izin direktori (`ls -ld /var/www/html` dan `sysctl fs.protected_regular`) menunjukkan direktori `/var/www/html` mewarisi izin `1777` (*world-writable sticky*), sehingga proteksi kernel Linux `fs.protected_regular = 2` memblokir penulisan file milik host UID `1000` oleh user `root` container. Masalah ini diselesaikan dengan menambahkan `chown root:root /var/www/html && chmod 0755 /var/www/html` pada `Dockerfile` dan `docker/entrypoint.sh`, lalu membangun ulang service `app`:
  ```bash
  docker compose up -d --build app
  ```

Setelah perbaikan tersebut, perintah konfigurasi Laravel pada container berjalan normal:
```bash
docker compose exec -T app php artisan key:generate --force
docker compose exec -T app php artisan migrate --seed --force
docker compose exec -T app php artisan optimize:clear
```
- **Catatan**: Untuk penggunaan interaktif oleh pengembang di terminal, flag `-T` bersifat opsional (cukup `docker compose exec app php artisan ...`).
- **Hasil**: `APP_KEY` terpasang di `.env`, seluruh 12 file migrasi berjalan di MySQL 8.0, `AdminSeeder` membuat akun admin `abarox` dari `ADMIN_PASSWORD`, dan `SiteContentSeeder` menyalin 7 gambar WebP ke `storage/app/public/media/` serta mengisi data awal seluruh tabel.

---

## 6. Pengembangan Backend

Seluruh model, migrasi, middleware, controller, dan seeder dibuat menggunakan perintah Artisan `make:*`:

```bash
cd /home/abarox/Desktop/tes && \
php artisan make:model Admin -m && \
php artisan make:model SiteSetting -m && \
php artisan make:model HeroSection -m && \
php artisan make:model Destination -m && \
php artisan make:model Activity -m && \
php artisan make:model Umkm -m && \
php artisan make:model Gallery -m && \
php artisan make:model Contact -m && \
php artisan make:model SocialLink -m && \
php artisan make:middleware AdminAuthenticate && \
php artisan make:middleware AdminGuest && \
php artisan make:controller PublicSiteController && \
php artisan make:controller Admin/AuthController && \
php artisan make:controller Admin/DashboardController && \
php artisan make:controller Admin/SiteSettingController && \
php artisan make:controller Admin/HeroSectionController --resource && \
php artisan make:controller Admin/DestinationController --resource && \
php artisan make:controller Admin/ActivityController --resource && \
php artisan make:controller Admin/UmkmController --resource && \
php artisan make:controller Admin/GalleryController --resource && \
php artisan make:controller Admin/ContactController --resource && \
php artisan make:controller Admin/SocialLinkController --resource && \
php artisan make:controller Admin/MediaController && \
php artisan make:controller Admin/ProfileController && \
php artisan make:seeder AdminSeeder && \
php artisan make:seeder SiteContentSeeder
```
- **Fungsi perintah**: Menghasilkan 9 file model dan 9 file migrasi database, 2 middleware autentikasi admin, 1 controller publik, 11 controller admin (termasuk `--resource` untuk CRUD standar), serta 2 kelas seeder.
- **Implementasi tambahan**:
  - Konfigurasi guard `'admin'` dan provider `'admins'` ditambahkan pada `config/auth.php`, serta konfigurasi kredensial seeder admin pada `config/admin.php`.
  - Logika berulang antar model diekstrak ke trait `HasContentScopes`, `HasManagedImage`, dan `HasUniqueSlug`.
  - Logika penyimpanan, validasi MIME, penyalinan aset seeder, serta pembersihan file lama yang aman dikonsolidasikan di `App\Services\MediaService` dan trait controller `HandlesContentImages`.
  - Pengambilan data halaman publik dan penghitungan statistik dashboard dipisahkan ke `App\Services\SiteContentService` dengan caching pengaturan situs yang otomatis dibersihkan setiap ada pembaruan di CMS.

---

## 7. Pengembangan Frontend

- **Tipografi & Gaya Visual**: Menggunakan `Newsreader Variable` untuk tajuk editorial dan `Plus Jakarta Sans Variable` untuk teks isi dan antarmuka admin. Palet warna pantai (Deep Ocean Blue, Turquoise, Sand Beige, Warm White, Muted Green, dan Dark Charcoal) diterapkan konsisten di `resources/css/app.css`.
- **Halaman Publik**: Tersusun atas partial modular pada `resources/views/public/partials/` (`navbar`, `hero`, `about`, `destinations`, `banner`, `activities`, `umkm`, `gallery`, `location`, `footer`) dengan bentuk persegi panjang tegas, grid asimetris, modal detail spot, filter kategori galeri + lightbox interaktif, embed peta OpenStreetMap, animasi `IntersectionObserver`, serta toggle Dark/Light mode berbasis `localStorage`.
- **Verifikasi ikon dan kompilasi aset**:
  ```bash
  node -e "const l = require('./node_modules/lucide/dist/cjs/lucide.js'); const names = ['Sun','Moon','Menu','X','MapPin','Compass','ArrowRight','ArrowUpRight','ArrowLeft','ChevronLeft','ChevronRight','Clock','Phone','Mail','Globe','Instagram','Facebook','Youtube','Share2','Info','Camera','Utensils','Coffee','Fish','ShoppingBag','Trees','Waves','Eye','EyeOff','Plus','Pencil','Trash2','Upload','Image','LayoutDashboard','Settings','Layers','Map','Store','Images','LogOut','User','Check','AlertCircle','ExternalLink','Maximize2','ChevronDown','FolderOpen','Sparkles']; console.log(names.filter(n => !l[n]));"
  ```
  ```bash
  cd /home/abarox/Desktop/tes && grep -rn "—" resources/ database/ app/ || echo "NO_EM_DASH" && npm run build
  ```
  - **Fungsi perintah**: Memverifikasi nama ekspor ikon dari paket `lucide` (terdeteksi bahwa `Instagram`, `Facebook`, dan `Youtube` tidak lagi tersedia di paket ikon inti sehingga dibuat komponen SVG khusus `components/social-icon.blade.php`), memeriksa ketiadaan karakter em dash (`—`), serta mengompilasi aset CSS, JS, dan font produksi menggunakan Vite.
  - **Hasil**: `vite build` menghasilkan `public/build/manifest.json` beserta bundel CSS (`93.13 kB`), JS (`17.29 kB`), dan font `.woff2` lokal.

---

## 8. Proses AI Image Generation

Pembuatan aset visual dilakukan melalui subagent AI *image generator* (tanpa perintah CLI eksternal) berdasarkan prompt deskriptif khusus Pantai Selat Baru. Sebanyak **7 foto realistis beresolusi tinggi** berhasil dibuat dalam format JPG sebelum layanan generator gambar mencapai batas kuota (*HTTP 429 RESOURCE_EXHAUSTED*):
1. `hero_panoramic_coastline` (garis pantai landai pagi hari, cemara laut, dan kelapa)
2. `hero_aerial_shoreline` (foto udara lengkung pantai utara Bengkalis)
3. `hero_golden_hour_horizon` (suasana senja keemasan di atas pasir pasang surut)
4. `hero_ocean_horizon_breeze` (tepi air dangkal pirus dengan ranting cemara laut)
5. `spot_garis_pantai_landai` (hamparan pasir surut memantulkan langit pagi)
6. `spot_hamparan_pasir_pesisir` (detail riak pasir alami dan air jernih)
7. `spot_panorama_selat_malaka` (panorama laut Selat Malaka dengan dua perahu kayu nelayan tradisional)

Setiap gambar diperiksa secara visual lalu dioptimasi ke format **WebP** menggunakan Python Pillow (`quality=84`, `method=6`) dan disimpan ke `resources/seed-media/` agar dapat di-commit bersama kode sumber dan disalin otomatis ke `storage/app/public/media/` oleh seeder:

```bash
python3 - <<'PY'
import os, glob
from PIL import Image

src_dir = "/home/abarox/.gemini/antigravity/brain/b8d4a5ff-c89e-4004-b67b-7b63b5df33a3"
dst_dir = "/home/abarox/Desktop/tes/resources/seed-media"
os.makedirs(dst_dir, exist_ok=True)
# Konversi 7 gambar JPG ke WebP proporsional (lebar maks 1920px hero, 1400px spot)
PY
```
- **Hasil**: Ketujuh gambar terkompresi menjadi `79.9 KB` hingga `170.1 KB` per berkas tanpa mengurangi ketajaman detail. Sisa 15 aset yang belum dapat dibuat akibat batas kuota didokumentasikan secara jujur beserta prompt individualnya di `docs/aset-visual-pending.md`.

---

## 9. Pengembangan Admin CMS

Panel administrasi pada rute `/admin` dibangun dengan antarmuka produktif yang terpisah dari halaman publik menggunakan layout `resources/views/layouts/admin.blade.php`:
- **Autentikasi & Middleware**: Menggunakan guard `admin` dan tabel `admins`, dengan login throttled (`throttle:10,1`), hashing password, regenerasi session saat login, dan invalidasi session saat logout.
- **Dashboard**: Menampilkan metrik ringkasan spot wisata, galeri, UMKM, aktivitas, total konten, pratinjau hero aktif, serta akses cepat pembaruan.
- **Manajemen Konten Lengkap**: Formulir terpadu untuk Pengaturan Website (`SiteSettingController`), variasi Hero beserta tombol pengaktifan satu klik (`HeroSectionController`), serta CRUD penuh untuk `Destination`, `Activity`, `Umkm`, `Gallery`, `Contact`, `SocialLink`, dan `Profile`.
- **Manajemen Gambar (`components/admin/image-field.blade.php` & `MediaController`)**: Mendukung pratinjau langsung sebelum unggah, pemilih aset dari pustaka media yang sudah ada, pemilihan *focal point* (`object-position`), penghapusan opsional gambar, serta pembersihan otomatis file lama di `storage/app/public/media/` apabila tidak lagi dirujuk oleh konten lain.

---

## 10. Pengujian Aplikasi

Pengujian menyeluruh dilakukan dalam tiga lapis:

1. **Pengujian Otomatis PHPUnit (`tests/Feature/PantaiSelatBaruTest.php` dan `ExampleTest.php`)**:
   ```bash
   cd /home/abarox/Desktop/tes && php artisan test
   ```
   - **Hasil**: `9` test case dengan `58` assertion seluruhnya berstatus **passed** (`1172 ms`), mencakup rendering homepage publik, proteksi rute admin tanpa login, login/logout admin, CRUD destinasi beserta penghapusan file gambar lama saat update/delete, penolakan unggahan file non-gambar, pengaktifan variasi hero dan toggle section, serta CRUD UMKM dan galeri.

2. **Pengujian Integrasi HTTP Live pada Container Docker (`http://localhost:8000`)**:
   Dilakukan pengujian langsung terhadap container Nginx + PHP-FPM + MySQL menggunakan Python `urllib` dengan cookie session nyata:
   - Login admin (`POST /admin/login`) dengan kredensial dari `.env` -> berhasil masuk ke `/admin`.
   - Pengujian seluruh `18` rute GET admin (`/admin`, `/admin/settings`, `/admin/heroes`, `/admin/destinations`, `/admin/activities`, `/admin/umkm`, `/admin/galleries`, `/admin/contacts`, `/admin/social-links`, `/admin/media`, `/admin/profile`, serta form `create`) -> seluruhnya mengembalikan status `200 OK`.
   - Pengujian upload gambar multipart WebP nyata ke `/admin/media`, verifikasi penyajian file via Nginx (`/storage/media/uploads/...` -> `200 OK`), penghapusan kembali file media uji (`DELETE /admin/media`), serta proses logout.
   - Pemeriksaan log error aplikasi melalui `docker compose exec -T app cat storage/logs/laravel.log` -> tidak ditemukan error.

3. **Audit HTML Ter-render & Verifikasi Record Database**:
   - Audit HTML pada `http://localhost:8000/` memastikan tidak ada karakter em dash (`—`), seluruh seksi dan atribut interaktif (`data-theme-toggle`, `data-lightbox`, `data-spot-modal`, `openstreetmap.org/export/embed.html`) tampil lengkap, serta seluruh `9` aset lokal (CSS, JS, dan 7 gambar WebP) mengembalikan `HTTP 200`.
   - Verifikasi langsung record Eloquent pada MySQL di container `app` menghasilkan: `admins:1 settings:42 heroes:4 destinations:6 activities:4 umkm:4 galleries:7 contacts:3 social:2`.
   - *Catatan*: Upaya inspeksi menggunakan subagent Chrome DevTools tidak dapat terhubung ke browser Chrome host karena *remote debugging* Chrome tidak sedang aktif di host (`DevToolsActivePort` tidak ditemukan), sehingga verifikasi visual langsung dilakukan melalui pengujian HTTP, audit DOM/aset, dan pengujian PHPUnit.

---

## 11. Git dan GitHub

Inisialisasi repository lokal dan pengiriman kode sumber ke GitHub (`https://github.com/barbarbarox/wisata-pantai.git`, branch `main`) dijalankan dari root proyek menggunakan:

```bash
git init
git add .
git commit -m "Initial commit: Pantai Selat Baru Tourism Website"
git branch -M main
git remote add origin https://github.com/barbarbarox/wisata-pantai.git
git push -u origin main
```
- **Fungsi perintah**:
  - `git init`: Menginisialisasi repository Git baru di direktori proyek.
  - `git add .`: Menambahkan seluruh file proyek yang tidak dikecualikan `.gitignore` ke area staging (memastikan `.env`, `vendor/`, `node_modules/`, `public/build/`, dan runtime `storage/app/public/*` tidak ikut terbawa).
  - `git commit -m "..."`: Mencatat snapshot awal seluruh source code, aset seeder (`resources/seed-media/`), konfigurasi Docker, serta dokumentasi.
  - `git branch -M main`: Memastikan nama branch aktif adalah `main`.
  - `git remote add origin ...`: Menghubungkan repository lokal ke remote GitHub tujuan.
  - `git push -u origin main`: Mengunggah seluruh riwayat commit pada branch `main` ke GitHub dan menyetel tracking upstream.

---

## 12. Kesimpulan

Website profil wisata **Pantai Selat Baru** beserta Admin CMS telah berhasil dibangun, dijalankan di atas stack Docker (PHP 8.3 FPM, Nginx, MySQL 8.0, dan Vite), serta diuji secara fungsional. Seluruh bagian halaman publik dapat dikelola secara dinamis melalui panel `/admin`, termasuk pergantian tema terang/gelap, manajemen galeri dan media gambar, serta integrasi peta OpenStreetMap. Sebagai pengembangan lanjutan, pengelola dapat menambahkan 15 foto dokumentasi UMKM dan aktivitas sesuai panduan prompt di `docs/aset-visual-pending.md` secara bertahap melalui menu Admin CMS tanpa perlu mengubah kode sumber.
