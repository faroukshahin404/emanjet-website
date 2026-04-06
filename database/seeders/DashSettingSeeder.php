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
            ['key' => 'logo.sidebar', 'value' => 'img/brand/logo.svg', 'type' => 'image', 'group' => 'logos'],
            ['key' => 'logo.auth', 'value' => 'img/brand/logo.svg', 'type' => 'image', 'group' => 'logos'],
            ['key' => 'favicon', 'value' => 'img/brand/logo.svg', 'type' => 'image', 'group' => 'logos'],
            ['key' => 'project_name', 'value' => config('app.name', 'SuperJet'), 'type' => 'text', 'group' => 'general'],
            ['key' => 'copyright.link', 'value' => config('app.url', '#'), 'type' => 'url', 'group' => 'copyright'],
            ['key' => 'copyright.text', 'value' => config('app.name', 'SuperJet'), 'type' => 'text', 'group' => 'copyright'],
            ['key' => 'color.primary', 'value' => '#696cff', 'type' => 'color', 'group' => 'colors'],
            ['key' => 'color.secondary', 'value' => '#8592a3', 'type' => 'color', 'group' => 'colors'],
            ['key' => 'color.success', 'value' => '#71dd37', 'type' => 'color', 'group' => 'colors'],
            ['key' => 'color.info', 'value' => '#03c3ec', 'type' => 'color', 'group' => 'colors'],
            ['key' => 'color.warning', 'value' => '#ffab00', 'type' => 'color', 'group' => 'colors'],
            ['key' => 'color.danger', 'value' => '#ff3e1d', 'type' => 'color', 'group' => 'colors'],
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
