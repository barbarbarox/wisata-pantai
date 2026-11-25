<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table): void {
            $table->id();
            $table->string('title', 160);
            $table->string('slug')->unique();
            $table->string('category', 80);
            $table->text('summary');
            $table->longText('description');
            $table->string('best_time', 120)->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_alt', 255)->nullable();
            $table->string('focal_point', 40)->default('center center');
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
