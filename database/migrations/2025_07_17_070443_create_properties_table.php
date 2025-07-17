<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('country')->default('USA');
            $table->enum('type', ['residential', 'commercial', 'retail', 'office', 'industrial', 'land']);
            $table->decimal('price', 12, 2);
            $table->enum('status', ['for_sale', 'for_lease', 'sold', 'leased']);
            $table->integer('square_footage')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('parking_spaces')->nullable();
            $table->year('year_built')->nullable();
            $table->json('features')->nullable(); // Store as JSON array
            $table->string('featured_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('brochure_url')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
            
            $table->index(['status', 'is_active']);
            $table->index(['type', 'is_active']);
            $table->index(['is_featured', 'is_active']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};