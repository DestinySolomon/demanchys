<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'name' => 'Paystack',
                'description' => 'Pay online via Paystack (Cards, Bank Transfer, USSD)',
                'type' => 'paystack',
                'icon' => 'fas fa-bolt',
                'is_active' => true,
                'is_default' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bank Transfer',
                'description' => 'Make direct bank transfer to our account',
                'type' => 'bank_transfer',
                'icon' => 'fas fa-university',
                'is_active' => true,
                'is_default' => false,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mobile Money',
                'description' => 'Pay via OPay, Palmpay, or other mobile money',
                'type' => 'mobile_money',
                'icon' => 'fas fa-mobile-alt',
                'is_active' => true,
                'is_default' => false,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Only insert if the table is empty
        if (DB::table('payment_methods')->count() === 0) {
            DB::table('payment_methods')->insert($paymentMethods);
            $this->command->info('✅ Default payment methods seeded successfully!');
        } else {
            $this->command->info('⚠️  Payment methods table already has data. Skipping seeder.');
        }
    }
}