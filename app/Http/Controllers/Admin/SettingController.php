<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    /**
     * Display the main settings page with all tabs.
     */
    public function index()
    {
        // Load all settings grouped by their category
        $settings = [
            'general' => Setting::getByGroup('general'),
            'appearance' => Setting::getByGroup('appearance'),
            'security' => Setting::getByGroup('security'),
            'integration' => Setting::getByGroup('integration'),
            'notification' => Setting::getByGroup('notification'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update general settings.
     */
    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'site_phone' => 'nullable|string|max:20',
            'site_address' => 'nullable|string|max:500',
            'currency' => 'required|string|size:3',
            'timezone' => 'required|string|timezone',
            'site_description' => 'nullable|string|max:500',
            'site_keywords' => 'nullable|string|max:500',
            'site_status' => 'required|in:active,maintenance',
            'maintenance_message' => 'nullable|string|max:1000',
        ]);

        // Update each setting
        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value);
        }

        // Clear cache
        Cache::forget('settings.general');
        Cache::forget('settings.all');

        return response()->json([
            'success' => true,
            'message' => 'General settings updated successfully!'
        ]);
    }

    /**
     * Update logo and favicon.
     */
    public function updateLogo(Request $request)
    {
        try {
            $request->validate([
                'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
                'favicon' => 'nullable|image|mimes:ico,png,jpg,jpeg|max:1024',
                'remove_logo' => 'nullable|boolean',
                'remove_favicon' => 'nullable|boolean',
            ]);

            $responseData = [];

            // Handle logo
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                
                // Delete old logo if exists
                $oldLogo = Setting::getValue('logo');
                if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                    Storage::disk('public')->delete($oldLogo);
                }

                // Store new logo
                $path = $logo->store('settings', 'public');
                
                // Update or create logo setting with correct group and type
                Setting::updateOrCreate(
                    ['key' => 'logo'],
                    [
                        'value' => $path,
                        'group' => 'appearance', // Changed from default 'general'
                        'label' => 'Logo',
                        'type' => 'file', // Changed from default 'text'
                        'sort_order' => 1
                    ]
                );
                
                $responseData[] = 'Logo uploaded successfully';
            } 
            elseif ($request->has('remove_logo') && $request->boolean('remove_logo')) {
                // Remove logo
                $oldLogo = Setting::getValue('logo');
                if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                    Storage::disk('public')->delete($oldLogo);
                }
                Setting::where('key', 'logo')->delete();
                $responseData[] = 'Logo removed';
            }

            // Handle favicon
            if ($request->hasFile('favicon')) {
                $favicon = $request->file('favicon');
                
                // Delete old favicon if exists
                $oldFavicon = Setting::getValue('favicon');
                if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                    Storage::disk('public')->delete($oldFavicon);
                }

                // Store new favicon
                $path = $favicon->store('settings', 'public');
                
                // Update or create favicon setting with correct group and type
                Setting::updateOrCreate(
                    ['key' => 'favicon'],
                    [
                        'value' => $path,
                        'group' => 'appearance', // Changed from default 'general'
                        'label' => 'Favicon',
                        'type' => 'file', // Changed from default 'text'
                        'sort_order' => 2
                    ]
                );
                
                $responseData[] = 'Favicon uploaded successfully';
            } 
            elseif ($request->has('remove_favicon') && $request->boolean('remove_favicon')) {
                // Remove favicon
                $oldFavicon = Setting::getValue('favicon');
                if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                    Storage::disk('public')->delete($oldFavicon);
                }
                Setting::where('key', 'favicon')->delete();
                $responseData[] = 'Favicon removed';
            }

            // Clear cache
            Cache::forget('settings.appearance');
            Cache::forget('settings.all');

            $message = !empty($responseData) ? implode(', ', $responseData) : 'No changes made';

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            Log::error('Logo update error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update Google reCAPTCHA settings.
     */
    public function updateRecaptcha(Request $request)
    {
        $validated = $request->validate([
            'recaptcha_site_key' => 'nullable|string|max:255',
            'recaptcha_secret_key' => 'nullable|string|max:255',
            'recaptcha_enabled' => 'boolean',
        ]);

        $validated['recaptcha_enabled'] = $request->has('recaptcha_enabled') ? 1 : 0;

        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value, 'security');
        }

        Cache::forget('settings.security');
        Cache::forget('settings.all');

        return response()->json([
            'success' => true,
            'message' => 'reCAPTCHA settings updated successfully!'
        ]);
    }

    /**
     * Update WhatsApp settings.
     */
    public function updateWhatsapp(Request $request)
    {
        $validated = $request->validate([
            'whatsapp_enabled' => 'boolean',
            'whatsapp_number' => 'nullable|string|max:20',
            'whatsapp_message' => 'nullable|string|max:500',
            'whatsapp_position' => 'nullable|in:left,right',
            'whatsapp_delay' => 'nullable|integer|min:0',
        ]);

        $validated['whatsapp_enabled'] = $request->has('whatsapp_enabled') ? 1 : 0;

        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value, 'integration');
        }

        Cache::forget('settings.integration');
        Cache::forget('settings.all');

        return response()->json([
            'success' => true,
            'message' => 'WhatsApp settings updated successfully!'
        ]);
    }

    /**
     * Update Google Analytics settings.
     */
    public function updateAnalytics(Request $request)
    {
        $validated = $request->validate([
            'google_analytics_id' => 'nullable|string|max:255',
            'google_analytics_enabled' => 'boolean',
            'facebook_pixel_id' => 'nullable|string|max:255',
            'facebook_pixel_enabled' => 'boolean',
        ]);

        $validated['google_analytics_enabled'] = $request->has('google_analytics_enabled') ? 1 : 0;
        $validated['facebook_pixel_enabled'] = $request->has('facebook_pixel_enabled') ? 1 : 0;

        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value);
        }

        Cache::forget('settings.integration');
        Cache::forget('settings.all');

        return response()->json([
            'success' => true,
            'message' => 'Analytics settings updated successfully!'
        ]);
    }

    /**
     * Update dark mode settings.
     */
    public function updateDarkMode(Request $request)
    {
        $validated = $request->validate([
            'dark_mode_enabled' => 'boolean',
            'dark_mode_default' => 'boolean',
            'dark_mode_toggle' => 'boolean',
        ]);

        $validated['dark_mode_enabled'] = $request->has('dark_mode_enabled') ? 1 : 0;
        $validated['dark_mode_default'] = $request->has('dark_mode_default') ? 1 : 0;
        $validated['dark_mode_toggle'] = $request->has('dark_mode_toggle') ? 1 : 0;

        foreach ($validated as $key => $value) {
            Setting::setValue($key, $value);
        }

        Cache::forget('settings.appearance');
        Cache::forget('settings.all');

        return response()->json([
            'success' => true,
            'message' => 'Dark mode settings updated successfully!'
        ]);
    }

    /**
     * Clear database cache and selected data.
     */
    public function clearDatabase(Request $request)
    {
        $request->validate([
            'clear_cache' => 'boolean',
            'clear_views' => 'boolean',
            'clear_logs' => 'boolean',
            'clear_sessions' => 'boolean',
            'clear_backups' => 'boolean',
        ]);

        $actions = [];

        try {
            // Clear application cache
            if ($request->has('clear_cache') && $request->clear_cache) {
                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('route:clear');
                Artisan::call('view:clear');
                $actions[] = 'Application cache cleared';
            }

            // Clear compiled views
            if ($request->has('clear_views') && $request->clear_views) {
                Artisan::call('view:clear');
                $actions[] = 'Compiled views cleared';
            }

            // Clear log files
            if ($request->has('clear_logs') && $request->clear_logs) {
                Artisan::call('log:clear');
                $actions[] = 'Log files cleared';
            }

            // Clear sessions
            if ($request->has('clear_sessions') && $request->clear_sessions) {
                DB::table('sessions')->truncate();
                $actions[] = 'Sessions cleared';
            }

            // Clear backup files
            if ($request->has('clear_backups') && $request->clear_backups) {
                $backupPath = storage_path('app/backup');
                if (file_exists($backupPath)) {
                    array_map('unlink', glob("$backupPath/*.*"));
                    rmdir($backupPath);
                }
                $actions[] = 'Backup files cleared';
            }

            $message = $actions ? implode(', ', $actions) . ' successfully!' : 'No actions were performed.';

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error clearing database: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current settings for a specific group.
     */
    public function getSettings($group)
    {
        $settings = Setting::getByGroup($group);
        return response()->json([
            'success' => true,
            'settings' => $settings
        ]);
    }
}