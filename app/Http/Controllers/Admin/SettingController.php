<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DashSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the settings management page.
     */
    public function index()
    {
        $settings = [
            'app_android_link'               => DashSetting::get('app_android_link', ''),
            'app_android_active'             => DashSetting::get('app_android_active', '0'),
            'app_ios_link'                   => DashSetting::get('app_ios_link', ''),
            'app_ios_active'                 => DashSetting::get('app_ios_active', '0'),
            'booking_hours_before_departure' => DashSetting::get('booking_hours_before_departure', '8'),
        ];

        return view('admin.pages.settings.index', compact('settings'));
    }

    /**
     * Save the settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'app_android_link'               => ['nullable', 'url', 'max:500'],
            'app_ios_link'                   => ['nullable', 'url', 'max:500'],
            'booking_hours_before_departure' => ['required', 'integer', 'min:0', 'max:72'],
        ]);

        // App links
        DashSetting::set('app_android_link', $request->input('app_android_link'), 'url', 'app_links', 'Google Play Store link');
        DashSetting::set('app_android_active', $request->boolean('app_android_active') ? '1' : '0', 'boolean', 'app_links', 'Show Android app link');

        DashSetting::set('app_ios_link', $request->input('app_ios_link'), 'url', 'app_links', 'App Store link');
        DashSetting::set('app_ios_active', $request->boolean('app_ios_active') ? '1' : '0', 'boolean', 'app_links', 'Show iOS app link');

        // Booking setting
        DashSetting::set(
            'booking_hours_before_departure',
            $request->input('booking_hours_before_departure'),
            'number',
            'booking',
            'Minimum hours before departure allowed to book'
        );

        return redirect()->route('admin.settings.index')
            ->with('success', __('Settings updated successfully.'));
    }
}
