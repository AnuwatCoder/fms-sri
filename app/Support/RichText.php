<?php

namespace App\Support;

class RichText
{
    public static function sanitize(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        $value = str_replace(["\r\n", "\r"], "\n", $value);
        $value = preg_replace('#<(script|style)\b[^>]*>.*?</\1>#is', '', $value) ?? '';
        $value = preg_replace('/<(div|p)\b[^>]*>/i', '', $value) ?? '';
        $value = preg_replace('/<\/(div|p)>/i', '<br>', $value) ?? '';
        $value = strip_tags($value, '<strong><b><em><i><u><br>');
        $value = preg_replace('/<(strong|b|em|i|u|br)\b[^>]*>/i', '<$1>', $value) ?? '';
        $value = str_ireplace(['<b>', '</b>', '<i>', '</i>'], ['<strong>', '</strong>', '<em>', '</em>'], $value);
        $value = str_replace("\n", '<br>', $value);
        $value = preg_replace('/(?:<br>\s*){3,}/i', '<br><br>', $value) ?? '';
        $value = preg_replace('/^(?:\s|<br>)+|(?:\s|<br>)+$/i', '', $value) ?? '';

        return $value === '' ? null : $value;
    }

    public static function toPlainText(?string $value): string
    {
        $html = self::sanitize($value) ?? '';
        $text = str_ireplace('<br>', ' ', $html);
        $text = html_entity_decode(strip_tags($text), ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return trim(preg_replace('/\s+/u', ' ', $text) ?? '');
    }

    /** @return array<int, string> */
    public static function toListItems(?string $value): array
    {
        $html = self::sanitize($value);

        if (! $html) {
            return [];
        }

        return collect(preg_split('/<br\s*\/?>/i', $html) ?: [])
            ->map(fn (string $item): string => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
