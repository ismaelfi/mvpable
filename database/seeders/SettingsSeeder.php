<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(['id' => 1], [
            'site_name' => 'MVPable',
            'site_description' => 'Comprehensive Minimal SaaS starter kit with all necessary components',
            'support_email' => 'ismael@mvpable.com',
            'support_phone' => '123-456-7890',
            'google_analytics_id' => 'UA-XXXXX-Y',
            'html_snippet' => '<script>/* custom snippet */</script>',
            'seo_title' => 'MVPable – Comprehensive Minimal SaaS Starter Kit',
            'seo_keywords' => 'MVPable, SaaS Starter Kit, Minimal SaaS, Comprehensive SaaS, SaaS Components',
            'seo_metadata' => json_encode([
                'description' => 'MVPable is a comprehensive and minimal SaaS starter kit with all necessary components for your SaaS development.',
                'author' => 'MVPable Team',
                'robots' => 'index, follow',
            ]),
            'favicon' => 'images/favicon.ico',
            'logo' => 'images/logo.png',
        ]);
    }
}
