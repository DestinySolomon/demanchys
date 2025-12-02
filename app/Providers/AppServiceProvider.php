<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Load settings into cache and share with all views so admin updates apply immediately.
        try {
            // Flatten settings as key => value
            $allSettings = Cache::remember('settings.all', 60, function () {
                return Setting::all()->pluck('value', 'key')->toArray();
            });

            // Also keep groups available (e.g. appearance, general) - cache per group
            $groups = ['general', 'appearance', 'security', 'integration', 'notification'];
            $grouped = [];
            foreach ($groups as $group) {
                $grouped[$group] = Cache::remember("settings.{$group}", 60, function () use ($group) {
                    return Setting::getByGroup($group);
                });
            }

            // Provide a settings version (timestamp) for cache busting in templates
            $latestUpdate = Setting::max('updated_at');
            $settingsVersion = $latestUpdate ? strtotime($latestUpdate) : time();

            // Make them available in all views
            View::share('settings', $allSettings);
            View::share('settingsGroups', $grouped);
            View::share('settings_version', $settingsVersion);
        } catch (\Exception $e) {
            // If settings table doesn't exist yet or other errors occur ignore gracefully in boot
        }
    }
}
