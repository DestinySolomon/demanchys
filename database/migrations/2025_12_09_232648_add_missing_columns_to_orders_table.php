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
        Schema::table('orders', function (Blueprint $table) {
            // Add order_ref column if it doesn't exist
            if (!Schema::hasColumn('orders', 'order_ref')) {
                $table->string('order_ref')->nullable()->unique()->after('order_number');
            }
            
            // Add payment_reference column if it doesn't exist
            if (!Schema::hasColumn('orders', 'payment_reference')) {
                $table->string('payment_reference')->nullable()->unique()->after('order_ref');
            }
            
            // Add payment_date column if it doesn't exist
            if (!Schema::hasColumn('orders', 'payment_date')) {
                $table->timestamp('payment_date')->nullable()->after('payment_status');
            }
            
            // Add tax_amount column if it doesn't exist
            if (!Schema::hasColumn('orders', 'tax_amount')) {
                $table->decimal('tax_amount', 10, 2)->default(0)->after('subtotal');
            }
            
            // Add discount_amount column if it doesn't exist
            if (!Schema::hasColumn('orders', 'discount_amount')) {
                $table->decimal('discount_amount', 10, 2)->default(0)->after('delivery_fee');
            }
            
            // Add delivery_instructions column if it doesn't exist
            if (!Schema::hasColumn('orders', 'delivery_instructions')) {
                $table->text('delivery_instructions')->nullable()->after('discount_amount');
            }
            
            // Add coupon_id column if it doesn't exist
            if (!Schema::hasColumn('orders', 'coupon_id')) {
                $table->foreignId('coupon_id')->nullable()->constrained('coupons')->onDelete('set null')->after('delivery_instructions');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop columns if they exist
            if (Schema::hasColumn('orders', 'coupon_id')) {
                $table->dropForeign(['coupon_id']);
                $table->dropColumn('coupon_id');
            }
            
            if (Schema::hasColumn('orders', 'delivery_instructions')) {
                $table->dropColumn('delivery_instructions');
            }
            
            if (Schema::hasColumn('orders', 'discount_amount')) {
                $table->dropColumn('discount_amount');
            }
            
            if (Schema::hasColumn('orders', 'tax_amount')) {
                $table->dropColumn('tax_amount');
            }
            
            if (Schema::hasColumn('orders', 'payment_date')) {
                $table->dropColumn('payment_date');
            }
            
            if (Schema::hasColumn('orders', 'payment_reference')) {
                $table->dropColumn('payment_reference');
            }
            
            if (Schema::hasColumn('orders', 'order_ref')) {
                $table->dropColumn('order_ref');
            }
        });
    }
};
