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
        Schema::table('users', function (Blueprint $table) {
            // Rename existing columns to be more consistent
            $table->renameColumn('phone', 'mobile_number');
            $table->renameColumn('avatar', 'profile_image');
            
            // Add new columns
            $table->text('bio')->nullable()->after('address');
            $table->string('facebook_url')->nullable()->after('bio');
            $table->string('twitter_url')->nullable()->after('facebook_url');
            $table->string('instagram_url')->nullable()->after('twitter_url');
            $table->string('linkedin_url')->nullable()->after('instagram_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Reverse renames
            $table->renameColumn('mobile_number', 'phone');
            $table->renameColumn('profile_image', 'avatar');
            
            // Drop added columns
            $table->dropColumn(['bio', 'facebook_url', 'twitter_url', 'instagram_url', 'linkedin_url']);
        });
    }
};