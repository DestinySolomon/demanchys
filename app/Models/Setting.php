<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'options',
        'sort_order'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    // Get setting value by key
    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    // Set setting value - FIXED VERSION
    public static function setValue($key, $value, $group = 'general')
    {
        // First, try to find existing setting
        $setting = self::where('key', $key)->first();
        
        if ($setting) {
            // Update existing setting
            $setting->value = $value;
            $setting->group = $group;
            $setting->save();
        } else {
            // Create new setting with all required fields
            $setting = self::create([
                'key' => $key,
                'value' => $value,
                'group' => $group,
                'label' => ucwords(str_replace(['_', '-'], ' ', $key)),
                'type' => 'text',
                'sort_order' => 0
            ]);
        }
        
        return $setting;
    }

    // Get all settings by group
    public static function getByGroup($group)
    {
        return self::where('group', $group)
                   ->orderBy('sort_order')
                   ->get()
                   ->keyBy('key');
    }

    // Bulk update settings
    public static function bulkUpdate($data)
    {
        foreach ($data as $key => $value) {
            self::setValue($key, $value);
        }
    }
}