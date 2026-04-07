<?php

namespace App\Support;

/**
 * Normalizes footer social links from PageSeo content_json (new "links" format or legacy flat keys).
 */
final class SocialMediaLinks
{
    /**
     * @return array<int, array{icon_class: string, url: string, visible: bool}>
     */
    public static function forFooter(array|string|null $localeBranch): array
    {
        if (! is_array($localeBranch)) {
            return [];
        }

        if (isset($localeBranch['links']) && is_array($localeBranch['links'])) {
            return collect($localeBranch['links'])
                ->map(function ($row) {
                    return [
                        'icon_class' => trim((string) ($row['icon_class'] ?? '')),
                        'url' => trim((string) ($row['url'] ?? '')),
                        'visible' => filter_var($row['visible'] ?? true, FILTER_VALIDATE_BOOL),
                    ];
                })
                ->filter(fn (array $r) => $r['visible'] && $r['url'] !== '' && $r['icon_class'] !== '')
                ->values()
                ->all();
        }

        $map = self::legacyKeyToIconClass();

        $out = [];
        foreach ($map as $key => $iconClass) {
            $url = trim((string) ($localeBranch[$key] ?? ''));
            if ($url !== '') {
                $out[] = [
                    'icon_class' => $iconClass,
                    'url' => $url,
                    'visible' => true,
                ];
            }
        }

        return $out;
    }

    /**
     * @return array<string, string>
     */
    public static function legacyKeyToIconClass(): array
    {
        return [
            'facebook' => 'fa-brands fa-facebook-f',
            'twitter' => 'fa-brands fa-x-twitter',
            'instagram' => 'fa-brands fa-instagram',
            'linkedin' => 'fa-brands fa-linkedin-in',
        ];
    }

    /**
     * Presets for the admin editor (label => Font Awesome 6 class).
     *
     * @return array<string, string>
     */
    public static function iconPresets(): array
    {
        return [
            'Facebook' => 'fa-brands fa-facebook-f',
            'X (Twitter)' => 'fa-brands fa-x-twitter',
            'Instagram' => 'fa-brands fa-instagram',
            'LinkedIn' => 'fa-brands fa-linkedin-in',
            'YouTube' => 'fa-brands fa-youtube',
            'TikTok' => 'fa-brands fa-tiktok',
            'Snapchat' => 'fa-brands fa-snapchat',
            'WhatsApp' => 'fa-brands fa-whatsapp',
            'Telegram' => 'fa-brands fa-telegram',
        ];
    }
}
