<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemAddOnTable extends Migration
{
    public function up()
    {
        Schema::create('menu_item_add_on', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_item_id')->constrained('menu_items')->onDelete('cascade');
            $table->foreignId('add_on_id')->constrained('add_ons')->onDelete('cascade');
            $table->decimal('additional_price', 8, 2)->default(0.00); // if per-item price differs
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu_item_add_on');
    }
}
