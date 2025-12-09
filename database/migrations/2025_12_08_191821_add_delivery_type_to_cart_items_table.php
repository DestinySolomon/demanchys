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
        Schema::table('cart_items', function (Blueprint $table) {
            // Add delivery_type column to store order type per cart item
            $table->enum('delivery_type', ['eat_in', 'takeaway', 'home_delivery'])
                  ->nullable()
                  ->after('quantity')
                  ->default('eat_in')
                  ->comment('The delivery type for this cart item: eat_in, takeaway, or home_delivery');
            
            // Also add special_instructions if not already there
            if (!Schema::hasColumn('cart_items', 'special_instructions')) {
                $table->text('special_instructions')
                      ->nullable()
                      ->after('delivery_type');
            }
            
            // Add options column for storing addons and preferences as JSON
            if (!Schema::hasColumn('cart_items', 'options')) {
                $table->json('options')
                      ->nullable()
                      ->after('special_instructions');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            // Remove the columns we added
            $table->dropColumn('delivery_type');
            
            if (Schema::hasColumn('cart_items', 'special_instructions')) {
                $table->dropColumn('special_instructions');
            }
            
            if (Schema::hasColumn('cart_items', 'options')) {
                $table->dropColumn('options');
            }
        });
    }
};