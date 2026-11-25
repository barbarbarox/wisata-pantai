<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_sections', function (Blueprint $table): void {
            $table->id();
            $table->string('eyebrow', 120);
            $table->string('title', 180);
            $table->text('subtitle');
            $table->string('primary_cta_text', 80);
            $table->string('primary_cta_url', 255);
            $table->string('secondary_cta_text', 80)->nullable();
            $table->string('secondary_cta_url', 255)->nullable();
            $table->string('background_image')->nullable();
            $table->string('image_alt', 255)->nullable();
            $table->string('focal_point', 40)->default('center center');
            $table->boolean('is_active')->default(false)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_sections');
    }
};
