<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Make phone unique if not already
            $table->string('phone')->unique()->nullable()->change();
            
            // Add new fields for Google OAuth
            $table->timestamp('phone_verified_at')->nullable()->after('phone');
            $table->string('google_id')->nullable()->after('phone_verified_at');
            $table->string('avatar')->nullable()->after('google_id');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_verified_at', 'google_id', 'avatar']);
            $table->string('phone')->nullable(false)->change();
        });
    }
};