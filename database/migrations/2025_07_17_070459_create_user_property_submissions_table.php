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
        Schema::create('user_property_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->enum('type', ['residential', 'commercial', 'retail', 'office', 'industrial', 'land']);
            $table->decimal('price', 12, 2);
            $table->enum('status', ['for_sale', 'for_lease']);
            $table->integer('square_footage')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('parking_spaces')->nullable();
            $table->year('year_built')->nullable();
            $table->json('features')->nullable();
            $table->json('images')->nullable(); // Store image paths as JSON
            $table->enum('submission_status', ['pending', 'approved', 'rejected', 'needs_revision'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->foreignId('property_id')->nullable()->constrained()->onDelete('set null'); // Links to created property if approved
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'submission_status']);
            $table->index('submission_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_property_submissions');
    }
};