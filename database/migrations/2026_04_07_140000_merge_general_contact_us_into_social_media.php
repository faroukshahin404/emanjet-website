<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $page = DB::table('pages')->where('slug', 'general')->first();
        if (! $page) {
            return;
        }

        $contactRow = DB::table('page_seos')
            ->where('page_id', $page->id)
            ->where('section_type', 'contact-us')
            ->first();

        $socialRow = DB::table('page_seos')
            ->where('page_id', $page->id)
            ->where('section_type', 'social-media')
            ->first();

        if (! $socialRow) {
            return;
        }

        $defaults = [
            'email' => 'fa-solid fa-envelope',
            'phone' => 'fa-solid fa-phone',
            'whatsapp' => 'fa-brands fa-whatsapp',
            'complaints_email' => 'fa-solid fa-headset',
        ];

        $socialJson = json_decode($socialRow->content_json, true) ?? [];

        $hasContact = isset($socialJson['en']['contact']) && is_array($socialJson['en']['contact']);
        if ($hasContact && ! $contactRow) {
            return;
        }

        foreach (['en', 'ar'] as $lang) {
            $flat = [];
            if ($contactRow) {
                $cj = json_decode($contactRow->content_json, true) ?? [];
                $flat = $cj[$lang] ?? [];
                $flat = is_array($flat) ? $flat : [];
            }

            if (! isset($socialJson[$lang]) || ! is_array($socialJson[$lang])) {
                $socialJson[$lang] = [];
            }

            $contact = [];
            foreach ($defaults as $key => $icon) {
                $contact[$key] = [
                    'value' => trim((string) ($flat[$key] ?? '')),
                    'visible' => true,
                    'icon_class' => $icon,
                ];
            }

            $socialJson[$lang]['contact'] = $contact;
        }

        DB::table('page_seos')->where('id', $socialRow->id)->update([
            'content_json' => json_encode($socialJson),
            'updated_at' => now(),
        ]);

        if ($contactRow) {
            DB::table('page_seos')->where('id', $contactRow->id)->delete();
        }
    }

    public function down(): void
    {
        // Not restored: contact-us rows were removed.
    }
};
