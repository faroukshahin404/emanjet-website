<?php

namespace Database\Seeders;

use App\Models\DashSetting;
use Illuminate\Database\Seeder;

class DashSettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['key' => 'theme.default', 'value' => 'light', 'type' => 'text', 'group' => 'theme'],
            ['key' => 'theme.layout_default', 'value' => 'sidebar', 'type' => 'text', 'group' => 'theme'],
            ['key' => 'logo.sidebar', 'value' => 'images/logo.png', 'type' => 'image', 'group' => 'logos'],
            ['key' => 'logo.auth', 'value' => 'images/logo.png', 'type' => 'image', 'group' => 'logos'],
            ['key' => 'favicon', 'value' => 'images/favicon/favicon.svg', 'type' => 'image', 'group' => 'logos'],
            ['key' => 'project_name', 'value' => config('app.name', 'SuperJet'), 'type' => 'text', 'group' => 'general'],
            ['key' => 'copyright.link', 'value' => config('app.url', '#'), 'type' => 'url', 'group' => 'copyright'],
            ['key' => 'copyright.text', 'value' => config('app.name', 'SuperJet'), 'type' => 'text', 'group' => 'copyright'],
            ['key' => 'color.primary', 'value' => '#D52034', 'type' => 'color', 'group' => 'colors'],
            ['key' => 'color.secondary', 'value' => '#3A3A3A', 'type' => 'color', 'group' => 'colors'],
            ['key' => 'color.success', 'value' => '#1B7F4F', 'type' => 'color', 'group' => 'colors'],
            ['key' => 'color.info', 'value' => '#0C4A6E', 'type' => 'color', 'group' => 'colors'],
            ['key' => 'color.warning', 'value' => '#C9A227', 'type' => 'color', 'group' => 'colors'],
            ['key' => 'color.danger', 'value' => '#9B1C26', 'type' => 'color', 'group' => 'colors'],
        ];

        foreach ($defaults as $row) {
            DashSetting::updateOrCreate(
                ['key' => $row['key']],
                [
                    'value' => $row['value'],
                    'type' => $row['type'],
                    'group' => $row['group'],
                ]
            );
        }
    }
}
