<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            
            // Foreign key with constraint
            $table->foreignId('menu_category_id')
                  ->constrained('menu_categories')
                  ->onDelete('cascade') // If category deleted, items are deleted
                  ->onUpdate('cascade');
            
            // Required fields with limits
            $table->string('name', 255);
            $table->string('slug', 255)->unique(); // Unique for SEO
            $table->text('description')->nullable();
            
            // Price with precision (avoid floating point issues)
            $table->decimal('price', 8, 2); // 999,999.99
            
            // Availability control
            $table->boolean('is_available')->default(true);
            $table->boolean('is_featured')->default(false);
            
            // Secure file paths
            $table->string('image')->nullable(); // Store only filename, not full path
            $table->string('thumbnail')->nullable();
            
            // Sorting and organization
            $table->integer('sort_order')->default(0);
            
            // Timestamps for auditing
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['menu_category_id', 'is_available']);
            $table->index(['is_featured', 'is_available']);
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};