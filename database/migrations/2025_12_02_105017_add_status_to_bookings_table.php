<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Add new columns
            $table->string('email')->nullable()->after('phone');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending')->after('note');
            $table->string('admin_notes')->nullable()->after('status');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete()->after('admin_notes');
            
            // Add indexes for better performance
            $table->index('status');
            $table->index('date');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['email', 'status', 'admin_notes', 'updated_by']);
            $table->dropIndex(['status', 'date', 'created_at']);
        });
    }
};