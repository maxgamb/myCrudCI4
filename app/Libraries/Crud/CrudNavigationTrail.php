<?php

declare(strict_types=1);

namespace App\Libraries\Crud;

/**
 * Cascaded navigation context used only for breadcrumbs and UI returns.
 *
 * IMPORTANTE: il trail non autorizza mai scritture e non determina FK. Le FK
 * restano validate dai Controller/Model contro lo schema generated.
 */
final class CrudNavigationTrail
{
    private const MAX_DEPTH = 8;

    /** @return list<array{table:string,id:string,label:string}> */
    public static function decode(mixed $value): array
    {
        if (!is_string($value) || trim($value) === '') {
            return [];
        }

        $raw = strtr(trim($value), '-_', '+/');
        $padding = strlen($raw) % 4;
        if ($padding !== 0) {
            $raw .= str_repeat('=', 4 - $padding);
        }
        $json = base64_decode($raw, true);
        if (!is_string($json) || $json === '') {
            return [];
        }
        $decoded = json_decode($json, true);

        return self::sanitize(is_array($decoded) ? $decoded : []);
    }

    /** @param list<array{table:string,id:string,label:string}> $trail */
    public static function encode(array $trail): string
    {
        $trail = self::sanitize($trail);
        if ($trail === []) {
            return '';
        }
        $json = json_encode($trail, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if (!is_string($json)) {
            return '';
        }

        return rtrim(strtr(base64_encode($json), '+/', '-_'), '=');
    }

    /**
     * @param list<array{table:string,id:string,label:string}> $trail
     * @return list<array{table:string,id:string,label:string}>
     */
    public static function append(array $trail, string $table, int|string $id, string $label = ''): array
    {
        $trail = self::sanitize($trail);
        $segment = self::segment($table, (string) $id, $label);
        if ($segment === null) {
            return $trail;
        }

        $last = $trail === [] ? null : $trail[array_key_last($trail)];
        if (is_array($last) && $last['table'] === $segment['table'] && $last['id'] === $segment['id']) {
            $trail[array_key_last($trail)] = $segment;
            return $trail;
        }

        $trail[] = $segment;
        if (count($trail) > self::MAX_DEPTH) {
            $trail = array_slice($trail, -self::MAX_DEPTH);
        }

        return array_values($trail);
    }

    /**
     * Trail to use when returning to the direct parent: if the parent is already
     * l'ultimo segmento, quel segmento viene rimosso e restano gli antenati.
     *
     * @param list<array{table:string,id:string,label:string}> $trail
     * @return list<array{table:string,id:string,label:string}>
     */
    public static function ancestorsForParent(array $trail, string $table, int|string $id): array
    {
        $trail = self::sanitize($trail);
        if ($trail === []) {
            return [];
        }
        $lastIndex = array_key_last($trail);
        $last = $trail[$lastIndex] ?? null;
        if (is_array($last) && $last['table'] === $table && $last['id'] === (string) $id) {
            unset($trail[$lastIndex]);
        }

        return array_values($trail);
    }

    /** @return list<array{table:string,id:string,label:string}> */
    private static function sanitize(array $trail): array
    {
        $clean = [];
        foreach ($trail as $item) {
            if (!is_array($item)) {
                continue;
            }
            $segment = self::segment(
                (string) ($item['table'] ?? ''),
                (string) ($item['id'] ?? ''),
                (string) ($item['label'] ?? '')
            );
            if ($segment !== null) {
                $clean[] = $segment;
            }
            if (count($clean) >= self::MAX_DEPTH) {
                break;
            }
        }

        return array_values($clean);
    }

    /** @return array{table:string,id:string,label:string}|null */
    private static function segment(string $table, string $id, string $label): ?array
    {
        $table = trim($table);
        $id = trim($id);
        if ($table === '' || $id === '' || preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $table) !== 1) {
            return null;
        }
        if (strlen($id) > 128) {
            return null;
        }
        $label = trim(strip_tags($label));
        if ($label === '') {
            $label = ucfirst(str_replace('_', ' ', $table)) . ' #' . $id;
        }
        if (strlen($label) > 160) {
            $label = substr($label, 0, 160);
        }

        return ['table' => $table, 'id' => $id, 'label' => $label];
    }
}
