<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            // Add missing columns
            $table->enum('event_type', ['party', 'corporate', 'special_dinner', 'live_music', 'wine_tasting', 'cooking_class', 'other'])->default('other')->after('description');
            $table->enum('status', ['draft', 'published', 'cancelled', 'completed'])->default('draft')->change();
            $table->string('location')->nullable()->after('event_date');
            $table->integer('capacity')->nullable()->after('location');
            $table->decimal('price', 8, 2)->nullable()->after('capacity');
            $table->string('contact_email')->nullable()->after('price');
            $table->string('contact_phone')->nullable()->after('contact_email');
            
            // Add index for better performance
            $table->index('event_type');
            $table->index('status');
            $table->index('event_date');
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            // Remove added columns
            $table->dropColumn([
                'event_type', 
                'location', 
                'capacity', 
                'price',
                'contact_email',
                'contact_phone'
            ]);
            
            // Remove indexes
            $table->dropIndex(['event_type']);
            $table->dropIndex(['status']);
            $table->dropIndex(['event_date']);
        });
    }
};