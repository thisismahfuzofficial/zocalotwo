<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        
        $setting = Setting::firstOrCreate(
            ['key' => 'site.title'],
            [
                'display_name' => 'name site-title',
                'value' => 'value site title',
                'details' => '',

                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'site.subtitle'],
            [
                'display_name' => 'name site-subtitle',
                'value' => 'value site subtitle',
                'details' => '',

                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'site.email'],
            [
                'display_name' => 'name site-email',
                'value' => 'value site title',
                'details' => '',

                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'site.phone'],
            [
                'display_name' => 'name site-phone',
                'value' => 'value site phone',
                'details' => '',

                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'site.description'],
            [
                'display_name' => 'name site-description',
                'value' => 'value site-description',
                'details' => '',

                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'site.logo'],
            [
                'display_name' => 'name site-logo',
                'value' => 'value site logo',
                'details' => '',

                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'facebook.link'],
            [
                'display_name' => 'facebook link',
                'value' => 'facebooklink',
                'details' => '',

                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'instagram.link'],
            [
                'display_name' => 'instagram logo',
                'value' => 'instagram link',
                'details' => '',

                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'tiktok.link'],
            [
                'display_name' => 'tiktok link',
                'value' => 'tiktok link',
                'details' => '',

                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'google.map'],
            [
                'display_name' => 'google map',
                'value' => 'no google map key' ,
                'details' => '',

                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'site.google_analytics_tracking_id'],
            [
                'display_name' => 'name site-google_analytics_tracking_id',
                'value' => 'value site google_analytics_tracking_id',
                'details' => '',

                'group' => 'Site',
            ]
        );

        $setting = Setting::firstOrCreate(
            ['key' => 'slide.laft'],
            [
                'display_name' => 'laft slide',
                'value' => 'value slide',
                'details' => '',
                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'slide.laft_top'],
            [
                'display_name' => 'laft slide Top',
                'value' => 'value slide',
                'details' => '',
                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'slide.laft_bottom'],
            [
                'display_name' => 'laft slide Bottom' ,
                'value' => 'value slide',
                'details' => '',
                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'slide.right'],
            [
                'display_name' => 'right slide',
                'value' => 'value slide',
                'details' => '',
                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'slide.right_top'],
            [
                'display_name' => 'right slide Top',
                'value' => 'value slide',
                'details' => '',
                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'slide.right_bottom'],
            [
                'display_name' => 'right slide Bottom',
                'value' => 'value slide',
                'details' => '',
                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'order.mail'],
            [
                'display_name' => 'Order Mail',
                'value' => 'value order mail',
                'details' => '',
                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'extra.charge'],
            [
                'display_name' => 'Extra Charge',
                'value' => 'Extra Chagre',
                'details' => '',
                'group' => 'Site',
            ]
        );
        $setting = Setting::firstOrCreate(
            ['key' => 'pdf.file'],
            [
                'display_name' => 'The Map',
                'value' => 'The Map',
                'details' => '',
                'group' => 'Site',
            ]
        );

        
    }
}
