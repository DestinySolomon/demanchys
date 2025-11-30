<?php

namespace Database\Seeders;

use App\Models\DeliveryMan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryManSeeder extends Seeder
{
    public function run()
    {
        DeliveryMan::create([
            'name' => 'John Delivery',
            'email' => 'john.delivery@demanchys.com',
            'phone' => '+1234567890',
            'gender' => 'male',
            'status' => 'active',
            'total_earnings' => 1180.04,
            'commission_rate' => 2.5,
            'available_balance' => 1075.54,
            'total_withdrawn' => 75.00,
            'pending_withdrawal' => 25.00,
            'address' => '123 Delivery Street, City, State 12345',
            'vehicle_type' => 'Motorcycle',
            'vehicle_number' => 'MC-1234',
            'last_active' => now(),
        ]);

        DeliveryMan::create([
            'name' => 'Sarah Rider',
            'email' => 'sarah.rider@demanchys.com',
            'phone' => '+1234567891',
            'gender' => 'female',
            'status' => 'active',
            'total_earnings' => 850.50,
            'commission_rate' => 2.5,
            'available_balance' => 780.25,
            'total_withdrawn' => 50.00,
            'pending_withdrawal' => 20.25,
            'address' => '456 Rider Avenue, City, State 12345',
            'vehicle_type' => 'Bicycle',
            'vehicle_number' => 'BC-5678',
            'last_active' => now()->subHours(2),
        ]);

        DeliveryMan::create([
            'name' => 'Mike Transport',
            'email' => 'mike.transport@demanchys.com',
            'phone' => '+1234567892',
            'gender' => 'male',
            'status' => 'inactive',
            'total_earnings' => 0,
            'commission_rate' => 2.5,
            'available_balance' => 0,
            'total_withdrawn' => 0,
            'pending_withdrawal' => 0,
            'address' => '789 Transport Road, City, State 12345',
            'vehicle_type' => 'Car',
            'vehicle_number' => 'CR-9012',
            'last_active' => now()->subDays(5),
        ]);
    }
}
