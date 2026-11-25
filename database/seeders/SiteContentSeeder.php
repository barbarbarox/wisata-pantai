<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Contact;
use App\Models\Destination;
use App\Models\Gallery;
use App\Models\HeroSection;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\Umkm;
use App\Services\MediaService;
use App\Services\SiteContentService;
use Illuminate\Database\Seeder;

class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        $media = app(MediaService::class);
        $contentService = app(SiteContentService::class);

        $heroPanoramic = $media->seedAsset('hero-panoramic-coastline.webp', 'heroes');
        $heroAerial = $media->seedAsset('hero-aerial-shoreline.webp', 'heroes');
        $heroGoldenHour = $media->seedAsset('hero-golden-hour-horizon.webp', 'heroes');
        $heroShorelineBreeze = $media->seedAsset('hero-ocean-horizon-breeze.webp', 'heroes');
        $spotGarisPantai = $media->seedAsset('spot-garis-pantai-landai.webp', 'spots');
        $spotHamparanPasir = $media->seedAsset('spot-hamparan-pasir-pesisir.webp', 'spots');
        $spotPanoramaLaut = $media->seedAsset('spot-panorama-selat-malaka.webp', 'spots');

        $settings = [
            // General
            [
                'key' => 'site_name',
                'group' => 'general',
                'label' => 'Nama Website',
                'type' => 'text',
                'value' => 'Pantai Selat Baru',
            ],
            [
                'key' => 'site_tagline',
                'group' => 'general',
                'label' => 'Subjudul Identitas Website',
                'type' => 'text',
                'value' => 'Pesisir Utara Pulau Bengkalis, Provinsi Riau',
            ],
            [
                'key' => 'site_description',
                'group' => 'general',
                'label' => 'Deskripsi Singkat SEO & Profil',
                'type' => 'textarea',
                'value' => 'Portal informasi resmi kawasan wisata Pantai Selat Baru di Desa Selat Baru, Kecamatan Bantan, Kabupaten Bengkalis. Menampilkan profil garis pantai landai, spot pesisir, aktivitas pengunjung, serta direktori UMKM lokal.',
            ],
            [
                'key' => 'site_logo',
                'group' => 'general',
                'label' => 'Logo Website (Opsional)',
                'type' => 'image',
                'value' => null,
            ],

            // Backgrounds
            [
                'key' => 'website_background_image',
                'group' => 'backgrounds',
                'label' => 'Background Utama Website (Opsional)',
                'type' => 'image',
                'value' => null,
            ],
            [
                'key' => 'promo_banner_image',
                'group' => 'backgrounds',
                'label' => 'Gambar Banner Jeda Editorial',
                'type' => 'image',
                'value' => $heroShorelineBreeze,
            ],
            [
                'key' => 'promo_banner_eyebrow',
                'group' => 'backgrounds',
                'label' => 'Label Banner Jeda',
                'type' => 'text',
                'value' => 'CATATAN PESISIR',
            ],
            [
                'key' => 'promo_banner_quote',
                'group' => 'backgrounds',
                'label' => 'Kutipan Editorial Banner Jeda',
                'type' => 'textarea',
                'value' => 'Garis pantai yang landai dan angin laut yang tenang menjadikan tepian Selat Malaka ruang terbuka bagi warga serta pelancong untuk melepas penat.',
            ],
            [
                'key' => 'footer_background_image',
                'group' => 'backgrounds',
                'label' => 'Gambar Latar Footer (Opsional)',
                'type' => 'image',
                'value' => null,
            ],

            // About / Introduction
            [
                'key' => 'section_about_active',
                'group' => 'about',
                'label' => 'Aktifkan Bagian Tentang Pantai',
                'type' => 'boolean',
                'value' => '1',
            ],
            [
                'key' => 'about_eyebrow',
                'group' => 'about',
                'label' => 'Eyebrow Tentang Pantai',
                'type' => 'text',
                'value' => 'MENGENAL KAWASAN',
            ],
            [
                'key' => 'about_title',
                'group' => 'about',
                'label' => 'Judul Bagian Tentang',
                'type' => 'text',
                'value' => 'Pantai Landai di Tepian Selat Malaka',
            ],
            [
                'key' => 'about_description',
                'group' => 'about',
                'label' => 'Paragraf Utama Tentang Pantai',
                'type' => 'textarea',
                'value' => "Terletak di Desa Selat Baru, Kecamatan Bantan, Kabupaten Bengkalis, Pantai Selat Baru merupakan kawasan pesisir utara Pulau Bengkalis yang menghadap langsung ke perairan Selat Malaka.\n\nKarakter pantai ini ditandai oleh kontur pasir yang datar dan landai serta barisan pepohonan cemara laut yang tumbuh alami di sepanjang tepian daratan. Saat air surut, hamparan pasir membuka ruang berjalan yang luas dan tenang bagi pengunjung.",
            ],
            [
                'key' => 'about_note',
                'group' => 'about',
                'label' => 'Catatan Geografis Tambahan',
                'type' => 'textarea',
                'value' => 'Posisinya berada di kawasan pesisir utara Bengkalis dengan batas wilayah perairan Selat Malaka di sisi utara serta desa-desa pesisir Kecamatan Bantan di sekitarnya.',
            ],
            [
                'key' => 'about_image',
                'group' => 'about',
                'label' => 'Foto Utama Bagian Tentang',
                'type' => 'image',
                'value' => $heroAerial,
            ],
            [
                'key' => 'about_secondary_image',
                'group' => 'about',
                'label' => 'Foto Pendamping Bagian Tentang',
                'type' => 'image',
                'value' => $spotHamparanPasir,
            ],

            // Destinations Section
            [
                'key' => 'section_destinations_active',
                'group' => 'sections',
                'label' => 'Aktifkan Bagian Spot Wisata',
                'type' => 'boolean',
                'value' => '1',
            ],
            [
                'key' => 'section_destinations_eyebrow',
                'group' => 'sections',
                'label' => 'Eyebrow Spot Wisata',
                'type' => 'text',
                'value' => 'JELAJAH KAWASAN',
            ],
            [
                'key' => 'section_destinations_title',
                'group' => 'sections',
                'label' => 'Judul Spot Wisata',
                'type' => 'text',
                'value' => 'Sudut Pantai dan Bentang Pesisir',
            ],
            [
                'key' => 'section_destinations_subtitle',
                'group' => 'sections',
                'label' => 'Subjudul Spot Wisata',
                'type' => 'textarea',
                'value' => 'Setiap titik di sepanjang garis pantai Selat Baru menawarkan karakter ruang yang berbeda, mulai dari dataran pasir pasang surut hingga teduhnya sabuk cemara laut.',
            ],

            // Activities Section
            [
                'key' => 'section_activities_active',
                'group' => 'sections',
                'label' => 'Aktifkan Bagian Aktivitas',
                'type' => 'boolean',
                'value' => '1',
            ],
            [
                'key' => 'section_activities_eyebrow',
                'group' => 'sections',
                'label' => 'Eyebrow Aktivitas',
                'type' => 'text',
                'value' => 'RAGAM KEGIATAN',
            ],
            [
                'key' => 'section_activities_title',
                'group' => 'sections',
                'label' => 'Judul Aktivitas',
                'type' => 'text',
                'value' => 'Aktivitas Wisata Sepanjang Hari',
            ],
            [
                'key' => 'section_activities_subtitle',
                'group' => 'sections',
                'label' => 'Subjudul Aktivitas',
                'type' => 'textarea',
                'value' => 'Kondisi ombak yang relatif tenang dan tepian berpasir rata memberi keleluasaan bagi pengunjung untuk beraktivitas santai sejak pagi hingga matahari terbenam.',
            ],

            // UMKM Section
            [
                'key' => 'section_umkm_active',
                'group' => 'sections',
                'label' => 'Aktifkan Bagian UMKM Lokal',
                'type' => 'boolean',
                'value' => '1',
            ],
            [
                'key' => 'section_umkm_eyebrow',
                'group' => 'sections',
                'label' => 'Eyebrow UMKM',
                'type' => 'text',
                'value' => 'EKONOMI PESISIR',
            ],
            [
                'key' => 'section_umkm_title',
                'group' => 'sections',
                'label' => 'Judul UMKM',
                'type' => 'text',
                'value' => 'Pelaku UMKM dan Kuliner Lokal',
            ],
            [
                'key' => 'section_umkm_subtitle',
                'group' => 'sections',
                'label' => 'Subjudul UMKM',
                'type' => 'textarea',
                'value' => 'Kehadiran pedagang warga sekitar melengkapi kunjungan ke tepi pantai dengan sajian kuliner pesisir, minuman segar, dan olahan hasil laut setempat. Data pelaku usaha dapat diperbarui langsung oleh pengelola melalui panel administrasi.',
            ],

            // Gallery Section
            [
                'key' => 'section_gallery_active',
                'group' => 'sections',
                'label' => 'Aktifkan Bagian Galeri',
                'type' => 'boolean',
                'value' => '1',
            ],
            [
                'key' => 'section_gallery_eyebrow',
                'group' => 'sections',
                'label' => 'Eyebrow Galeri',
                'type' => 'text',
                'value' => 'ARSIP VISUAL',
            ],
            [
                'key' => 'section_gallery_title',
                'group' => 'sections',
                'label' => 'Judul Galeri',
                'type' => 'text',
                'value' => 'Galeri Foto Pantai Selat Baru',
            ],
            [
                'key' => 'section_gallery_subtitle',
                'group' => 'sections',
                'label' => 'Subjudul Galeri',
                'type' => 'textarea',
                'value' => 'Dokumentasi bentang pesisir, dinamika pasang surut, perahu nelayan, dan peralihan cahaya dari pagi hingga senja.',
            ],

            // Location Section
            [
                'key' => 'section_location_active',
                'group' => 'location',
                'label' => 'Aktifkan Bagian Lokasi',
                'type' => 'boolean',
                'value' => '1',
            ],
            [
                'key' => 'section_location_eyebrow',
                'group' => 'location',
                'label' => 'Eyebrow Lokasi',
                'type' => 'text',
                'value' => 'PETA & AKSES',
            ],
            [
                'key' => 'section_location_title',
                'group' => 'location',
                'label' => 'Judul Lokasi',
                'type' => 'text',
                'value' => 'Lokasi Pantai Selat Baru',
            ],
            [
                'key' => 'section_location_subtitle',
                'group' => 'location',
                'label' => 'Subjudul Lokasi',
                'type' => 'textarea',
                'value' => 'Kawasan pantai berada di Desa Selat Baru, Kecamatan Bantan, Kabupaten Bengkalis, Provinsi Riau, di jalur pesisir utara Pulau Bengkalis.',
            ],
            [
                'key' => 'location_address',
                'group' => 'location',
                'label' => 'Alamat Lengkap Kawasan',
                'type' => 'textarea',
                'value' => 'Desa Selat Baru, Kecamatan Bantan, Kabupaten Bengkalis, Provinsi Riau',
            ],
            [
                'key' => 'location_latitude',
                'group' => 'location',
                'label' => 'Garis Lintang (Latitude)',
                'type' => 'text',
                'value' => '1.523000',
            ],
            [
                'key' => 'location_longitude',
                'group' => 'location',
                'label' => 'Garis Bujur (Longitude)',
                'type' => 'text',
                'value' => '102.229000',
            ],
            [
                'key' => 'location_access_note',
                'group' => 'location',
                'label' => 'Catatan Akses & Informasi Kunjungan',
                'type' => 'textarea',
                'value' => 'Titik koordinat merujuk pada kawasan Desa Selat Baru, Kecamatan Bantan. Informasi rute terkini, jadwal operasional resmi, dan ketentuan retribusi daerah dapat ditambahkan oleh pengelola melalui menu Pengaturan dan Kontak.',
            ],

            // Footer
            [
                'key' => 'footer_description',
                'group' => 'footer',
                'label' => 'Deskripsi Footer',
                'type' => 'textarea',
                'value' => 'Laman profil dan informasi wisata pesisir Pantai Selat Baru, Kecamatan Bantan, Kabupaten Bengkalis, Riau.',
            ],
            [
                'key' => 'footer_copyright',
                'group' => 'footer',
                'label' => 'Teks Hak Cipta Footer',
                'type' => 'text',
                'value' => 'Pantai Selat Baru, Kabupaten Bengkalis. Seluruh hak cipta dilindungi.',
            ],
        ];

        foreach ($settings as $item) {
            SiteSetting::updateOrCreate(['key' => $item['key']], $item);
        }

        // Hero Sections (multiple visual variations)
        $heroes = [
            [
                'eyebrow' => 'DESTINASI WISATA BENGKALIS',
                'title' => 'Pantai Selat Baru',
                'subtitle' => 'Garis pantai berpasir landai di pesisir utara Pulau Bengkalis, menghadap langsung ke tenangnya perairan Selat Malaka dengan naungan cemara laut.',
                'primary_cta_text' => 'Jelajahi Pantai',
                'primary_cta_url' => '#destinasi',
                'secondary_cta_text' => 'Lihat Galeri',
                'secondary_cta_url' => '#galeri',
                'background_image' => $heroPanoramic,
                'image_alt' => 'Pemandangan garis pantai landai Pantai Selat Baru pada pagi hari dengan pohon cemara laut dan kelapa',
                'focal_point' => 'center center',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'eyebrow' => 'DESTINASI WISATA BENGKALIS',
                'title' => 'Lengkung Pesisir Utara Bengkalis',
                'subtitle' => 'Hamparan pasir pasang surut yang membentang luas di tepi perairan Selat Malaka, berpadu dengan sabuk hijau vegetasi pantai.',
                'primary_cta_text' => 'Jelajahi Pantai',
                'primary_cta_url' => '#destinasi',
                'secondary_cta_text' => 'Lihat Galeri',
                'secondary_cta_url' => '#galeri',
                'background_image' => $heroAerial,
                'image_alt' => 'Tampak udara garis pantai Pantai Selat Baru yang melengkung landai di Kabupaten Bengkalis',
                'focal_point' => 'center center',
                'is_active' => false,
                'sort_order' => 2,
            ],
            [
                'eyebrow' => 'DESTINASI WISATA BENGKALIS',
                'title' => 'Senja Tenang di Tepian Selat',
                'subtitle' => 'Cahaya sore memantul di permukaan pasir surut yang basah, menghadirkan suasana pesisir yang teduh di ujung utara Bengkalis.',
                'primary_cta_text' => 'Jelajahi Pantai',
                'primary_cta_url' => '#destinasi',
                'secondary_cta_text' => 'Lihat Galeri',
                'secondary_cta_url' => '#galeri',
                'background_image' => $heroGoldenHour,
                'image_alt' => 'Suasana matahari terbenam di pesisir Pantai Selat Baru menghadap Selat Malaka',
                'focal_point' => 'center center',
                'is_active' => false,
                'sort_order' => 3,
            ],
            [
                'eyebrow' => 'DESTINASI WISATA BENGKALIS',
                'title' => 'Tepian Teduh Cemara Laut',
                'subtitle' => 'Air laut dangkal bergradasi biru pirus menyentuh pasir hangat di bawah semilir angin pesisir Kecamatan Bantan.',
                'primary_cta_text' => 'Jelajahi Pantai',
                'primary_cta_url' => '#destinasi',
                'secondary_cta_text' => 'Lihat Galeri',
                'secondary_cta_url' => '#galeri',
                'background_image' => $heroShorelineBreeze,
                'image_alt' => 'Tepi laut jernih Pantai Selat Baru dengan ranting pohon cemara laut di bagian kanan',
                'focal_point' => 'center center',
                'is_active' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($heroes as $hero) {
            HeroSection::updateOrCreate(['title' => $hero['title']], $hero);
        }

        // Destinations (Spot Wisata)
        $destinations = [
            [
                'name' => 'Dataran Pasir Pasang Surut',
                'slug' => 'dataran-pasir-pasang-surut',
                'category' => 'Garis Pantai',
                'short_description' => 'Hamparan pasir pantai yang sangat landai dan rata saat air laut surut, memantulkan cahaya langit pagi.',
                'description' => 'Salah satu ciri khas Pantai Selat Baru adalah kemiringan pantainya yang sangat landai. Ketika air laut surut, permukaan pasir basah membentuk dataran luas yang memanjang mengikuti garis pesisir dan aman untuk dilalui dengan berjalan kaki.',
                'additional_info' => 'Kondisi terluas terlihat saat fase surut pagi hingga menjelang siang hari.',
                'image_path' => $spotGarisPantai,
                'image_alt' => 'Dataran pasir pasang surut Pantai Selat Baru yang luas dan memantulkan langit pagi',
                'focal_point' => 'center center',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Tepian Pasir Beriak',
                'slug' => 'tepian-pasir-beriak',
                'category' => 'Hamparan Pasir',
                'short_description' => 'Tekstur pasir alami berwarna krem pucat dengan alur riak air laut yang dangkal dan jernih.',
                'description' => 'Pergeseran pasang surut secara alami meninggalkan pola riak halus di atas pasir halus Pantai Selat Baru. Area ini berbatasan langsung dengan perairan dangkal berwarna biru kehijauan yang tenang.',
                'additional_info' => 'Cocok untuk pengamatan alam pesisir dan fotografi lanskap jarak dekat.',
                'image_path' => $spotHamparanPasir,
                'image_alt' => 'Tekstur riak pasir alami Pantai Selat Baru bertemu perairan dangkal berwarna pirus',
                'focal_point' => 'center center',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Panorama Perairan Selat Malaka',
                'slug' => 'panorama-perairan-selat-malaka',
                'category' => 'Pemandangan Laut',
                'short_description' => 'Cakrawala terbuka menghadap perairan Selat Malaka dengan lalu lintas perahu nelayan tradisional.',
                'description' => 'Dari garis pantai Selat Baru, pengunjung dapat memandang langsung hamparan perairan Selat Malaka. Pada hari dengan jarak pandang cerah, perahu nelayan tradisional yang berlabuh maupun melintas di perairan dangkal menjadi bagian dari pemandangan keseharian pesisir Bengkalis.',
                'additional_info' => 'Menghadap ke arah utara Pulau Bengkalis.',
                'image_path' => $spotPanoramaLaut,
                'image_alt' => 'Pemandangan perairan Selat Malaka dari Pantai Selat Baru dengan dua perahu nelayan tradisional',
                'focal_point' => 'center center',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Jalur Teduh Cemara Laut',
                'slug' => 'jalur-teduh-cemara-laut',
                'category' => 'Area Teduh',
                'short_description' => 'Barisan pohon cemara laut dan kelapa di sepanjang batas daratan yang menyaring terik matahari siang.',
                'description' => 'Pepohonan cemara laut tumbuh memanjang di sepanjang bagian atas pantai, menciptakan zona teduh alami bagi pengunjung untuk beristirahat sambil menikmati hembusan angin laut dari Selat Malaka.',
                'additional_info' => 'Berbatasan langsung dengan area duduk santai warga dan jalur masuk pantai.',
                'image_path' => $heroShorelineBreeze,
                'image_alt' => 'Jalur tepi pantai Pantai Selat Baru yang dinaungi ranting pohon cemara laut',
                'focal_point' => 'right center',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Tepian Senja Selat Baru',
                'slug' => 'tepian-senja-selat-baru',
                'category' => 'Matahari Terbenam',
                'short_description' => 'Titik terbuka di sisi barat lengkung pantai untuk menyaksikan peralihan cahaya keemasan di atas air tenang.',
                'description' => 'Menjelang sore, pantulan sinar matahari di atas pasir basah dan gelombang air yang tenang menghadirkan suasana hening. Area terbuka di garis pantai menjadi tempat favorit pengunjung untuk menanti senja.',
                'additional_info' => 'Waktu pengamatan terbaik berada pada rentang menjelang matahari terbenam.',
                'image_path' => $heroGoldenHour,
                'image_alt' => 'Pemandangan senja keemasan di tepi air Pantai Selat Baru',
                'focal_point' => 'center center',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Lengkung Pesisir Timur Bantan',
                'slug' => 'lengkung-pesisir-timur-bantan',
                'category' => 'Garis Pantai',
                'short_description' => 'Sisi lengkung garis pantai yang memadukan sabuk hijau pesisir dengan perairan tenang berwarna pirus.',
                'description' => 'Dari sudut pandang yang lebih tinggi maupun saat menyusuri ujung garis pantai, lengkung alami pesisir Selat Baru memperlihatkan keterhubungan antara vegetasi pantai dan perairan dangkal di sepanjang Kecamatan Bantan.',
                'additional_info' => 'Dapat ditempuh dengan berjalan kaki menyusuri sisi timur pantai.',
                'image_path' => $heroAerial,
                'image_alt' => 'Bentang lengkung garis pantai Pantai Selat Baru dengan deretan pepohonan pantai',
                'focal_point' => 'center center',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($destinations as $spot) {
            Destination::updateOrCreate(['slug' => $spot['slug']], $spot);
        }

        // Activities
        $activities = [
            [
                'title' => 'Menyusuri Garis Pantai Landai',
                'slug' => 'menyusuri-garis-pantai-landai',
                'category' => 'Rekreasi Santai',
                'summary' => 'Berjalan kaki santai di atas pasir padat yang membentang luas ketika air laut mulai surut.',
                'description' => 'Kemiringan pantai yang landai memudahkan pengunjung dari berbagai usia untuk berjalan menyusuri tepi air tanpa terhalang karang terjal. Saat pagi hari, udara pesisir masih sejuk dan cahaya matahari terbit cukup lembut.',
                'best_time' => 'Pagi hari dan sore menjelang senja',
                'image_path' => $spotGarisPantai,
                'image_alt' => 'Hamparan pasir rata untuk berjalan santai di Pantai Selat Baru',
                'focal_point' => 'center center',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Bersantai di Bawah Teduh Cemara Laut',
                'slug' => 'bersantai-di-bawah-teduh-cemara-laut',
                'category' => 'Keluarga',
                'summary' => 'Menikmati angin laut di area pepohonan pantai bersama keluarga dan kerabat.',
                'description' => 'Deretan cemara laut di bagian atas garis pantai memberikan keteduhan alami sepanjang siang. Pengunjung kerap memanfaatkan ruang terbuka ini untuk duduk beristirahat sambil mengawasi pemandangan laut di hadapan mereka.',
                'best_time' => 'Siang hingga sore hari',
                'image_path' => $heroShorelineBreeze,
                'image_alt' => 'Pemandangan laut dari bawah naungan pohon cemara laut di Pantai Selat Baru',
                'focal_point' => 'center center',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Mengamati Aktivitas Perairan Selat Malaka',
                'slug' => 'mengamati-aktivitas-perairan-selat-malaka',
                'category' => 'Wisata Bahari',
                'summary' => 'Menyaksikan perahu nelayan lokal melaut serta panorama laut terbuka di jalur pelayaran internasional.',
                'description' => 'Berhadapan langsung dengan Selat Malaka memberi karakter tersendiri bagi Pantai Selat Baru. Pengunjung dapat melihat perahu nelayan tradisional yang bersandar di perairan dangkal serta bentang cakrawala laut yang luas.',
                'best_time' => 'Pagi hari saat jarak pandang cerah',
                'image_path' => $spotPanoramaLaut,
                'image_alt' => 'Perahu nelayan tradisional di perairan dangkal Selat Malaka dekat Pantai Selat Baru',
                'focal_point' => 'center center',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Fotografi Lanskap dan Cahaya Senja',
                'slug' => 'fotografi-lanskap-dan-cahaya-senja',
                'category' => 'Fotografi',
                'summary' => 'Mengabadikan pantulan langit di pasir basah, tekstur riak air, dan siluet pepohonan pesisir.',
                'description' => 'Permukaan pasir basah saat surut berfungsi seperti cermin alami yang memantulkan warna langit saat matahari mulai turun. Tekstur riak pasir juga memberi detail komposisi yang kuat bagi penggemar fotografi alam.',
                'best_time' => 'Sore hari menjelang matahari terbenam',
                'image_path' => $heroGoldenHour,
                'image_alt' => 'Pantulan cahaya matahari terbenam di pasir basah Pantai Selat Baru',
                'focal_point' => 'center center',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($activities as $activity) {
            Activity::updateOrCreate(['slug' => $activity['slug']], $activity);
        }

        // UMKM (Direktori Binaan - tanpa informasi fiktif atau foto palsu)
        $umkmList = [
            [
                'business_name' => 'Gerai Kuliner Pesisir Selat Baru',
                'slug' => 'gerai-kuliner-pesisir-selat-baru',
                'product_type' => 'Kuliner Khas Pesisir',
                'description' => 'Kelompok warung makan milik warga setempat di kawasan tepi pantai yang menyajikan hidangan rumahan dan masakan pesisir Melayu. Nama gerai spesifik dan daftar menu resmi dapat diperbarui oleh pengelola melalui CMS.',
                'contact_info' => null,
                'location_note' => 'Area deretan warung tepi pantai Desa Selat Baru',
                'image_path' => null,
                'image_alt' => null,
                'focal_point' => 'center center',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'business_name' => 'Lapak Kelapa Muda Pesisir',
                'slug' => 'lapak-kelapa-muda-pesisir',
                'product_type' => 'Minuman Segar',
                'description' => 'Pedagang minuman segar yang menawarkan kelapa muda serta minuman ringan di sekitar zona teduh cemara laut. Pengelola dapat menambahkan foto dokumentasi lapak dan kontak pedagang terverifikasi melalui menu Admin UMKM.',
                'contact_info' => null,
                'location_note' => 'Sekitar jalur teduh pohon cemara laut',
                'image_path' => null,
                'image_alt' => null,
                'focal_point' => 'center center',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'business_name' => 'Sajian Olahan Hasil Laut Lokal',
                'slug' => 'sajian-olahan-hasil-laut-lokal',
                'product_type' => 'Olahan Ikan & Hasil Laut',
                'description' => 'Usaha mikro warga pesisir yang mengolah hasil tangkapan nelayan sekitar menjadi sajian ikan bakar serta lauk siap santap bagi pengunjung yang datang bersama keluarga.',
                'contact_info' => null,
                'location_note' => 'Zona kuliner pengunjung Pantai Selat Baru',
                'image_path' => null,
                'image_alt' => null,
                'focal_point' => 'center center',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'business_name' => 'Kudapan dan Oleh-Oleh Khas Bengkalis',
                'slug' => 'kudapan-dan-oleh-oleh-khas-bengkalis',
                'product_type' => 'Kudapan & Produk Kemasan',
                'description' => 'Pelaku UMKM lokal yang menyediakan aneka makanan ringan tradisional dan produk olahan khas Kabupaten Bengkalis untuk buah tangan pengunjung.',
                'contact_info' => null,
                'location_note' => 'Area gerai UMKM Desa Selat Baru',
                'image_path' => null,
                'image_alt' => null,
                'focal_point' => 'center center',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($umkmList as $umkm) {
            Umkm::updateOrCreate(['slug' => $umkm['slug']], $umkm);
        }

        // Photo Gallery (All 7 curated AI coastal photographs)
        $galleries = [
            [
                'title' => 'Garis Pantai Pagi Hari',
                'caption' => 'Pemandangan menyeluruh pantai berpasir krem dengan pepohonan cemara laut dan kelapa di bawah cahaya pagi yang lembut.',
                'category' => 'Pantai',
                'image_path' => $heroPanoramic,
                'image_alt' => 'Pemandangan pagi garis Pantai Selat Baru dengan air pirus dan pepohonan pantai',
                'focal_point' => 'center center',
                'aspect_ratio' => 'wide',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Refleksi Langit di Pasir Surut',
                'caption' => 'Permukaan pasir basah yang rata saat air laut surut memantulkan awan pagi di sepanjang tepian Selat Baru.',
                'category' => 'Pantai',
                'image_path' => $spotGarisPantai,
                'image_alt' => 'Refleksi langit pagi di atas pasir basah Pantai Selat Baru saat surut',
                'focal_point' => 'center center',
                'aspect_ratio' => 'portrait',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Pola Riak Pasir dan Air Dangkal',
                'caption' => 'Tekstur pasir yang terbentuk alami oleh pergerakan pasang surut bertemu tepian air laut berwarna biru pirus.',
                'category' => 'Suasana',
                'image_path' => $spotHamparanPasir,
                'image_alt' => 'Detail pola riak pasir pantai dan air dangkal jernih di Selat Baru',
                'focal_point' => 'center center',
                'aspect_ratio' => 'landscape',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Perahu Nelayan di Selat Malaka',
                'caption' => 'Dua perahu kayu nelayan tradisional berlabuh tenang di perairan dangkal pesisir utara Bengkalis.',
                'category' => 'Aktivitas',
                'image_path' => $spotPanoramaLaut,
                'image_alt' => 'Dua perahu nelayan kayu di lepas Pantai Selat Baru menghadap Selat Malaka',
                'focal_point' => 'center center',
                'aspect_ratio' => 'square',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'title' => 'Lengkung Pesisir dari Ketinggian',
                'caption' => 'Batas alami antara hutan pantai yang hijau, hamparan pasir landai, dan perairan Selat Malaka.',
                'category' => 'Pantai',
                'image_path' => $heroAerial,
                'image_alt' => 'Foto udara lengkung garis pantai berpasir luas di Selat Baru Bengkalis',
                'focal_point' => 'center center',
                'aspect_ratio' => 'landscape',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'title' => 'Naungan Cemara di Tepi Air',
                'caption' => 'Ranting pohon cemara laut meneduhi tepi pantai yang tenang dengan gradasi air jernih di pagi hari.',
                'category' => 'Suasana',
                'image_path' => $heroShorelineBreeze,
                'image_alt' => 'Ranting cemara laut membingkai tepi air jernih Pantai Selat Baru',
                'focal_point' => 'center center',
                'aspect_ratio' => 'landscape',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'title' => 'Cahaya Senja di Cakrawala',
                'caption' => 'Matahari turun perlahan di garis cakrawala Selat Malaka dengan warna hangat di atas pasir yang basah.',
                'category' => 'Senja',
                'image_path' => $heroGoldenHour,
                'image_alt' => 'Pemandangan matahari terbenam berwarna keemasan di Pantai Selat Baru',
                'focal_point' => 'center center',
                'aspect_ratio' => 'wide',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 7,
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::updateOrCreate(['title' => $gallery['title']], $gallery);
        }

        // Contacts (Factual regional & geographic records, no fabricated phones/emails)
        $contacts = [
            [
                'label' => 'Alamat Kawasan',
                'type' => 'address',
                'value' => 'Desa Selat Baru, Kecamatan Bantan, Kabupaten Bengkalis, Provinsi Riau',
                'icon' => 'map-pin',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'label' => 'Letak Geografis',
                'type' => 'info',
                'value' => 'Pesisir utara Pulau Bengkalis, menghadap langsung ke perairan Selat Malaka',
                'icon' => 'compass',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'label' => 'Informasi Pengelola',
                'type' => 'info',
                'value' => 'Kontak resmi, jam pelayanan kawasan, dan nomor pengelola dapat ditambahkan melalui dashboard admin.',
                'icon' => 'info',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($contacts as $contact) {
            Contact::updateOrCreate(['label' => $contact['label']], $contact);
        }

        // Social Links (Inactive placeholder-free templates until real official URLs are configured)
        $socialLinks = [
            [
                'platform' => 'Instagram',
                'label' => 'Instagram Resmi Wisata Selat Baru',
                'url' => 'https://instagram.com',
                'icon' => 'instagram',
                'is_active' => false,
                'sort_order' => 1,
            ],
            [
                'platform' => 'Website Daerah',
                'label' => 'Portal Kabupaten Bengkalis',
                'url' => 'https://bengkaliskab.go.id',
                'icon' => 'globe',
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($socialLinks as $social) {
            SocialLink::updateOrCreate(['platform' => $social['platform']], $social);
        }

        $contentService->flushCache();
    }
}
