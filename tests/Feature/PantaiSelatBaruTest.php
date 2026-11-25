<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Destination;
use App\Models\Gallery;
use App\Models\HeroSection;
use App\Models\Umkm;
use Database\Seeders\SiteContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PantaiSelatBaruTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->seed(SiteContentSeeder::class);
        $this->admin = Admin::create([
            'name' => 'Pengelola Uji',
            'username' => 'abarox',
            'password' => Hash::make('RahasiaUji123!'),
        ]);
    }

    public function test_public_homepage_renders_seeded_coastal_sections(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('Pantai Selat Baru')
            ->assertSee('DESTINASI WISATA BENGKALIS')
            ->assertSee('Dataran Pasir Pasang Surut')
            ->assertSee('Menyusuri Garis Pantai Landai')
            ->assertSee('Gerai Kuliner Pesisir Selat Baru')
            ->assertSee('Garis Pantai Pagi Hari')
            ->assertSee('openstreetmap.org/export/embed.html');
    }

    public function test_admin_routes_require_authentication(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/settings')->assertRedirect('/admin/login');
        $this->get('/admin/destinations')->assertRedirect('/admin/login');
        $this->post('/admin/destinations', [])->assertRedirect('/admin/login');
    }

    public function test_admin_can_login_and_logout(): void
    {
        $this->post('/admin/login', [
            'username' => 'abarox',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('username');

        $this->post('/admin/login', [
            'username' => 'abarox',
            'password' => 'RahasiaUji123!',
        ])->assertRedirect('/admin');

        $this->assertAuthenticatedAs($this->admin, 'admin');

        $this->get('/admin')->assertStatus(200)->assertSee('Ringkasan Konten');

        $this->post('/admin/logout')->assertRedirect('/admin/login');
        $this->assertGuest('admin');
    }

    public function test_destination_crud_and_old_image_cleanup(): void
    {
        $this->actingAs($this->admin, 'admin');

        $firstImage = UploadedFile::fake()->image('spot-awal.jpg', 800, 600);
        $this->post('/admin/destinations', [
            'name' => 'Spot Cemara Uji',
            'category' => 'Area Teduh',
            'short_description' => 'Ringkasan spot uji coba.',
            'description' => 'Deskripsi lengkap spot uji coba.',
            'additional_info' => 'Catatan tambahan.',
            'focal_point' => 'center center',
            'sort_order' => 10,
            'is_active' => '1',
            'image' => $firstImage,
        ])->assertRedirect('/admin/destinations');

        $spot = Destination::where('name', 'Spot Cemara Uji')->firstOrFail();
        $firstPath = $spot->image_path;
        $this->assertNotNull($firstPath);
        Storage::disk('public')->assertExists($firstPath);

        $secondImage = UploadedFile::fake()->image('spot-baru.png', 800, 600);
        $this->put("/admin/destinations/{$spot->id}", [
            'name' => 'Spot Cemara Uji Diperbarui',
            'category' => 'Area Teduh',
            'short_description' => 'Ringkasan diperbarui.',
            'description' => 'Deskripsi lengkap diperbarui.',
            'focal_point' => 'top center',
            'sort_order' => 11,
            'is_active' => '1',
            'image' => $secondImage,
        ])->assertRedirect('/admin/destinations');

        $spot->refresh();
        $this->assertNotEquals($firstPath, $spot->image_path);
        Storage::disk('public')->assertMissing($firstPath);
        Storage::disk('public')->assertExists($spot->image_path);

        $secondPath = $spot->image_path;
        $this->delete("/admin/destinations/{$spot->id}")->assertRedirect('/admin/destinations');
        Storage::disk('public')->assertMissing($secondPath);
    }

    public function test_upload_validation_rejects_non_image_files(): void
    {
        $this->actingAs($this->admin, 'admin');

        $maliciousFile = UploadedFile::fake()->create('script.php', 20, 'application/x-php');

        $this->post('/admin/galleries', [
            'title' => 'Galeri Tidak Valid',
            'category' => 'Pantai',
            'aspect_ratio' => 'landscape',
            'focal_point' => 'center center',
            'sort_order' => 99,
            'image' => $maliciousFile,
        ])->assertSessionHasErrors('image');
    }

    public function test_admin_can_toggle_section_visibility_and_switch_active_hero(): void
    {
        $this->actingAs($this->admin, 'admin');

        $secondHero = HeroSection::where('is_active', false)->firstOrFail();
        $this->patch("/admin/heroes/{$secondHero->id}/activate")->assertRedirect('/admin/heroes');
        $this->assertTrue($secondHero->fresh()->is_active);

        $this->put('/admin/settings', [
            'settings' => [
                'site_name' => 'Pantai Selat Baru',
                'section_umkm_active' => '0',
                'section_about_active' => '1',
                'section_destinations_active' => '1',
                'section_activities_active' => '1',
                'section_gallery_active' => '1',
                'section_location_active' => '1',
            ],
        ])->assertRedirect('/admin/settings');

        $this->get('/')
            ->assertStatus(200)
            ->assertSee($secondHero->title)
            ->assertDontSee('id="umkm"');
    }

    public function test_umkm_and_gallery_crud_work(): void
    {
        $this->actingAs($this->admin, 'admin');

        $umkmPhoto = UploadedFile::fake()->image('warung-pesisir.jpg', 800, 600);
        $this->post('/admin/umkm', [
            'business_name' => 'Warung Pesisir Bantan',
            'product_type' => 'Kuliner Khas Pesisir',
            'description' => 'Menyajikan hidangan laut segar di tepi pantai.',
            'location_note' => 'Dekat pintu masuk utara',
            'focal_point' => 'center center',
            'sort_order' => 5,
            'is_active' => '1',
            'image' => $umkmPhoto,
        ])->assertRedirect('/admin/umkm');

        $umkm = Umkm::where('business_name', 'Warung Pesisir Bantan')->firstOrFail();
        Storage::disk('public')->assertExists($umkm->image_path);

        $galleryPhoto = UploadedFile::fake()->image('senja.webp', 1200, 800);
        $this->post('/admin/galleries', [
            'title' => 'Senja Uji',
            'category' => 'Senja',
            'aspect_ratio' => 'wide',
            'focal_point' => 'center center',
            'sort_order' => 8,
            'is_active' => '1',
            'image' => $galleryPhoto,
        ])->assertRedirect('/admin/galleries');

        $this->assertTrue(Gallery::where('title', 'Senja Uji')->exists());
    }
}
