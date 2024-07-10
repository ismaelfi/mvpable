<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class SettingsHelper
{
    public static function get($key, $default = null)
    {
        return Cache::rememberForever('setting_'.$key, function () use ($key, $default) {
            $value = Setting::where('key', $key)->value('value');
            Config::set('settings.'.$key, $value ?? $default);

            return $value ?? $default;
        });
    }

    public static function getLogo()
    {
        return self::get('logo', 'images/default-logo.png');
    }

    public static function getFavicon()
    {
        return self::get('favicon', 'images/default-favicon.ico');
    }

    public static function getSeoTitle()
    {
        return self::get('seo_title', config('app.name'));
    }

    public static function clearCache()
    {
        Cache::flush();
    }
}
