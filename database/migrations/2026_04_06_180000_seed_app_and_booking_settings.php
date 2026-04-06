<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Seed default app links and booking settings into dash_setting table.
     */
    public function up(): void
    {
        $defaults = [
            [
                'key'         => 'app_android_link',
                'value'       => null,
                'type'        => 'url',
                'group'       => 'app_links',
                'description' => 'Google Play Store link for the Android app',
            ],
            [
                'key'         => 'app_android_active',
                'value'       => '0',
                'type'        => 'boolean',
                'group'       => 'app_links',
                'description' => 'Show/hide the Android app link in footer and download modal',
            ],
            [
                'key'         => 'app_ios_link',
                'value'       => null,
                'type'        => 'url',
                'group'       => 'app_links',
                'description' => 'Apple App Store link for the iOS app',
            ],
            [
                'key'         => 'app_ios_active',
                'value'       => '0',
                'type'        => 'boolean',
                'group'       => 'app_links',
                'description' => 'Show/hide the iOS app link in footer and download modal',
            ],
            [
                'key'         => 'booking_hours_before_departure',
                'value'       => '8',
                'type'        => 'number',
                'group'       => 'booking',
                'description' => 'Minimum hours before departure that a user is allowed to book a seat',
            ],
        ];

        foreach ($defaults as $setting) {
            DB::table('dash_setting')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    public function down(): void
    {
        DB::table('dash_setting')->whereIn('key', [
            'app_android_link',
            'app_android_active',
            'app_ios_link',
            'app_ios_active',
            'booking_hours_before_departure',
        ])->delete();
    }
};
