<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            // Add only the two missing columns
            $table->boolean('is_featured')->default(false)->after('availability');
            $table->integer('sort_order')->default(0)->after('is_featured');
        });
    }

    public function down()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'sort_order']);
        });
    }
};