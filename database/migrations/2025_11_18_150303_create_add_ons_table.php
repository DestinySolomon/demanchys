<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddOnsTable extends Migration
{
    public function up()
    {
        Schema::create('add_ons', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. 'fish','beef','chicken','eba'...
            $table->decimal('price', 8, 2)->default(0.00); // price for add-on (can be 0)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('add_ons');
    }
}
