<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Customer name
            $table->string('designation')->nullable(); // e.g., "Food Enthusiast", "Event Host"
            $table->text('content');          // The testimonial text
            $table->integer('rating')->default(5); // 1-5 stars
            $table->string('image')->nullable(); // Customer photo
            $table->boolean('is_featured')->default(false); // Show on homepage
            $table->boolean('is_approved')->default(false); // Admin approval
            $table->integer('order')->default(0); // Display order
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('is_featured');
            $table->index('is_approved');
            $table->index('order');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('testimonials');
    }
};