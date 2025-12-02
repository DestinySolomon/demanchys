<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        $defaultSettings = [
            // ====================
            // GENERAL SETTINGS
            // ====================
            [
                'key' => 'site_name',
                'value' => 'De Manchys Lounge',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Name',
                'sort_order' => 1
            ],
            [
                'key' => 'site_email',
                'value' => 'info@demanchys.com',
                'type' => 'email',
                'group' => 'general',
                'label' => 'Site Email',
                'sort_order' => 2
            ],
            [
                'key' => 'site_phone',
                'value' => '+234 123 456 7890',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Phone',
                'sort_order' => 3
            ],
            [
                'key' => 'site_address',
                'value' => '123 Restaurant Street, Lagos, Nigeria',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Site Address',
                'sort_order' => 4
            ],
            [
                'key' => 'currency',
                'value' => 'NGN',
                'type' => 'select',
                'group' => 'general',
                'label' => 'Currency',
                'sort_order' => 5
            ],
            [
                'key' => 'timezone',
                'value' => 'Africa/Lagos',
                'type' => 'select',
                'group' => 'general',
                'label' => 'Timezone',
                'sort_order' => 6
            ],
            [
                'key' => 'site_description',
                'value' => 'Premium restaurant and lounge offering the best dining experience in Lagos',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Site Description',
                'sort_order' => 7
            ],
            [
                'key' => 'site_keywords',
                'value' => 'restaurant, lounge, food, drinks, lagos, nigeria, dining',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Site Keywords',
                'sort_order' => 8
            ],
            [
                'key' => 'site_status',
                'value' => 'active',
                'type' => 'select',
                'group' => 'general',
                'label' => 'Site Status',
                'sort_order' => 9
            ],
            [
                'key' => 'maintenance_message',
                'value' => 'Site is under maintenance. Please check back later.',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Maintenance Message',
                'sort_order' => 10
            ],

            // ====================
            // APPEARANCE SETTINGS
            // ====================
            [
                'key' => 'dark_mode_enabled',
                'value' => '1',
                'type' => 'checkbox',
                'group' => 'appearance',
                'label' => 'Dark Mode Enabled',
                'sort_order' => 1
            ],
            [
                'key' => 'dark_mode_default',
                'value' => '0',
                'type' => 'checkbox',
                'group' => 'appearance',
                'label' => 'Default to Dark Mode',
                'sort_order' => 2
            ],
            [
                'key' => 'dark_mode_toggle',
                'value' => '1',
                'type' => 'checkbox',
                'group' => 'appearance',
                'label' => 'Show Dark Mode Toggle',
                'sort_order' => 3
            ],

            // ====================
            // SECURITY SETTINGS
            // ====================
            [
                'key' => 'recaptcha_enabled',
                'value' => '0',
                'type' => 'checkbox',
                'group' => 'security',
                'label' => 'Google reCAPTCHA Enabled',
                'sort_order' => 1
            ],

            // ====================
            // INTEGRATION SETTINGS
            // ====================
            [
                'key' => 'whatsapp_enabled',
                'value' => '0',
                'type' => 'checkbox',
                'group' => 'integration',
                'label' => 'WhatsApp Chat Enabled',
                'sort_order' => 1
            ],
            [
                'key' => 'whatsapp_position',
                'value' => 'right',
                'type' => 'select',
                'group' => 'integration',
                'label' => 'WhatsApp Widget Position',
                'sort_order' => 2
            ],
            [
                'key' => 'whatsapp_delay',
                'value' => '5',
                'type' => 'number',
                'group' => 'integration',
                'label' => 'WhatsApp Popup Delay',
                'sort_order' => 3
            ],
            [
                'key' => 'google_analytics_enabled',
                'value' => '0',
                'type' => 'checkbox',
                'group' => 'integration',
                'label' => 'Google Analytics Enabled',
                'sort_order' => 4
            ],
            [
                'key' => 'facebook_pixel_enabled',
                'value' => '0',
                'type' => 'checkbox',
                'group' => 'integration',
                'label' => 'Facebook Pixel Enabled',
                'sort_order' => 5
            ],
        ];

        foreach ($defaultSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('✅ Default settings seeded successfully!');
        $this->command->info('📊 Total settings: ' . count($defaultSettings));
    }
}