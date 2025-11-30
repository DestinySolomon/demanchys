<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('add_ons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('additional_price', 8, 2);
            $table->boolean('is_available')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Pivot table for menu_items and add_ons (many-to-many)
        Schema::create('menu_item_add_on', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('add_on_id')->constrained()->onDelete('cascade');
            $table->decimal('additional_price', 8, 2)->default(0);
            $table->timestamps();
            
            // Unique constraint to prevent duplicates
            $table->unique(['menu_item_id', 'add_on_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_item_add_on');
        Schema::dropIfExists('add_ons');
    }
};