<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Simply update the enum values
        DB::statement("ALTER TABLE delivery_men MODIFY status ENUM('pending', 'active', 'inactive', 'rejected') DEFAULT 'pending'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE delivery_men MODIFY status ENUM('active', 'inactive') DEFAULT 'active'");
    }
};