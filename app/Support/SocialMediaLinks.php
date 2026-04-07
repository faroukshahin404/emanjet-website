<?php

namespace App\Support;

/**
 * Normalizes footer social links and public contact fields from PageSeo general / social-media JSON.
 */
final class SocialMediaLinks
{
    /**
     * Contact detail keys stored under content_json[locale].contact[key].
     *
     * @return list<string>
     */
    public static function contactFieldKeys(): array
    {
        return ['email', 'phone', 'whatsapp', 'complaints_email'];
    }

    /**
     * Default icon (Font Awesome 6) per contact field.
     */
    public static function defaultIconForContactField(string $key): string
    {
        return match ($key) {
            'email' => 'fa-solid fa-envelope',
            'phone' => 'fa-solid fa-phone',
            'whatsapp' => 'fa-brands fa-whatsapp',
            'complaints_email' => 'fa-solid fa-headset',
            default => 'fa-solid fa-link',
        };
    }

    /**
     * Empty contact structure for one locale.
     *
     * @return array<string, array{value: string, visible: bool, icon_class: string}>
     */
    public static function emptyContactStructure(): array
    {
        $out = [];
        foreach (self::contactFieldKeys() as $key) {
            $out[$key] = [
                'value' => '',
                'visible' => true,
                'icon_class' => self::defaultIconForContactField($key),
            ];
        }

        return $out;
    }

    /**
     * Flat map for footer & contact page: phone, email, whatsapp, complaints_email (locale-specific values, visibility respected).
     *
     * @param  array<string, mixed>|null  $socialLocaleBranch  One locale branch of social-media JSON (e.g. content_json.en)
     * @param  array<string, mixed>|null  $legacyFlat  Legacy flat contact-us fields for fallback
     * @return array<string, string>
     */
    public static function contactForPublic(?array $socialLocaleBranch, ?array $legacyFlat): array
    {
        $keys = self::contactFieldKeys();
        $out = [];

        if (is_array($socialLocaleBranch)) {
            $contact = $socialLocaleBranch['contact'] ?? null;
            if (is_array($contact)) {
                foreach ($keys as $key) {
                    $block = $contact[$key] ?? null;
                    if (! is_array($block)) {
                        continue;
                    }
                    $visible = filter_var($block['visible'] ?? true, FILTER_VALIDATE_BOOL);
                    $val = trim((string) ($block['value'] ?? ''));
                    if ($visible && $val !== '') {
                        $out[$key] = $val;
                    }
                }
            }
        }

        if ($out !== []) {
            return $out;
        }

        if (is_array($legacyFlat)) {
            foreach ($keys as $key) {
                $v = trim((string) ($legacyFlat[$key] ?? ''));
                if ($v !== '') {
                    $out[$key] = $v;
                }
            }
        }

        return $out;
    }

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
    /**
     * Suggested icons for contact detail rows (admin picks or types custom class).
     *
     * @return array<string, string>
     */
    public static function contactIconPresetChoices(): array
    {
        return [
            'Email' => 'fa-solid fa-envelope',
            'Phone' => 'fa-solid fa-phone',
            'WhatsApp' => 'fa-brands fa-whatsapp',
            'Headset / complaints' => 'fa-solid fa-headset',
            'Link' => 'fa-solid fa-link',
        ];
    }

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
