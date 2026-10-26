<?php

namespace App\Services\LogicGuard;

class PageDiffer
{
    private const RULES = [
        'forms' => ['error', 'error'],
        'fields' => ['error', 'error'],
        'actions' => ['error', 'error'],
        'vue' => ['error', 'error'],
        'scripts' => ['error', 'error'],
        'events' => ['error', 'error'],
        'links' => ['error', 'warning'],
        'data' => ['error', 'warning'],
        'ids' => ['error', null],
        'text' => ['warning', null],
    ];

    private const WILDCARD = '⁎';

    public static function diff(array $before, array $after, array $volatile = []): array
    {
        $issues = [];

        foreach ($before as $key => $old) {
            if (!isset($after[$key])) {
                $issues[] = self::issue('error', $key, 'page', 'page is no longer rendered (route removed or now skipped)');
                continue;
            }
            $new = $after[$key];

            $fields = is_int($old['status']) && $old['status'] >= 500 ? ['status'] : ['status', 'location', 'type', 'body', 'error'];
            foreach ($fields as $field) {
                if (($old[$field] ?? null) !== ($new[$field] ?? null) && !isset($volatile[$key][$field])) {
                    $issues[] = self::issue('error', $key, $field, json_encode($old[$field] ?? null) . ' → ' . json_encode($new[$field] ?? null));
                }
            }
            if (count($fields) === 1 || !isset($old['fp'], $new['fp'])) {
                continue;
            }

            foreach (self::RULES as $category => [$onRemove, $onAdd]) {
                $patterns = $volatile[$key][$category] ?? [];
                [$removed, $added] = self::multisetDiff(
                    self::mask($old['fp'][$category] ?? [], $patterns),
                    self::mask($new['fp'][$category] ?? [], $patterns),
                );
                foreach ($removed as $item) {
                    if ($onRemove) {
                        $issues[] = self::issue($onRemove, $key, $category, '− ' . $item);
                    }
                }
                foreach ($added as $item) {
                    if ($onAdd) {
                        $issues[] = self::issue($onAdd, $key, $category, '+ ' . $item);
                    }
                }
            }

            if (($old['fp']['title'] ?? '') !== ($new['fp']['title'] ?? '') && !isset($volatile[$key]['title'])) {
                $issues[] = self::issue('warning', $key, 'title', $old['fp']['title'] . ' → ' . $new['fp']['title']);
            }

            foreach ($old['fp']['hooks'] ?? [] as $class => $count) {
                $now = $new['fp']['hooks'][$class] ?? 0;
                if ($now < $count && !isset($volatile[$key]['hooks'][$class])) {
                    $issues[] = self::issue('error', $key, 'hooks', ".{$class}: {$count} → {$now} elements");
                }
            }
        }

        foreach (array_diff_key($after, $before) as $key => $_) {
            $issues[] = self::issue('warning', $key, 'page', 'new page not in the baseline');
        }

        return $issues;
    }

    public static function volatility(array $first, array $second): array
    {
        $volatile = [];
        foreach ($first as $key => $a) {
            $b = $second[$key] ?? [];
            foreach (['status', 'location', 'type', 'body', 'error'] as $field) {
                if (($a[$field] ?? null) !== ($b[$field] ?? null)) {
                    $volatile[$key][$field] = true;
                }
            }
            if (!isset($a['fp'], $b['fp'])) {
                continue;
            }
            foreach (array_keys(self::RULES) as $category) {
                [$removed, $added] = self::multisetDiff($a['fp'][$category] ?? [], $b['fp'][$category] ?? []);
                if ($removed || $added) {
                    $volatile[$key][$category] = self::patterns($removed, $added);
                }
            }
            if (($a['fp']['title'] ?? '') !== ($b['fp']['title'] ?? '')) {
                $volatile[$key]['title'] = true;
            }
            foreach ($a['fp']['hooks'] ?? [] as $class => $count) {
                if (($b['fp']['hooks'][$class] ?? 0) !== $count) {
                    $volatile[$key]['hooks'][$class] = true;
                }
            }
        }
        return $volatile;
    }

    private static function patterns(array $removed, array $added): array
    {
        $patterns = [];
        foreach ($removed as $old) {
            $oldTokens = explode(' ', $old);
            $best = null;
            $bestScore = -1;
            foreach ($added as $i => $new) {
                $newTokens = explode(' ', $new);
                if (count($newTokens) !== count($oldTokens) || $oldTokens[0] !== $newTokens[0]) {
                    continue;
                }
                $score = count(array_intersect_assoc($oldTokens, $newTokens));
                if ($score > $bestScore) {
                    [$best, $bestScore] = [$i, $score];
                }
            }
            if ($best === null) {
                $patterns[] = $old;
                continue;
            }
            $newTokens = explode(' ', $added[$best]);
            unset($added[$best]);
            $pattern = [];
            foreach ($oldTokens as $i => $token) {
                if ($token === $newTokens[$i]) {
                    $pattern[] = $token;
                } else {
                    $eq = strpos($token, '=');
                    $pattern[] = ($eq !== false ? substr($token, 0, $eq + 1) : '') . self::WILDCARD;
                }
            }
            $patterns[] = implode(' ', $pattern);
        }
        return array_values(array_unique(array_merge($patterns, array_values($added))));
    }

    private static function mask(array $items, array $patterns): array
    {
        if ($patterns === []) {
            return $items;
        }
        $regexes = [];
        foreach ($patterns as $p) {
            $regexes[$p] = '/^' . str_replace(preg_quote(self::WILDCARD, '/'), '\S*', preg_quote($p, '/')) . '$/u';
        }
        return array_map(function ($item) use ($regexes) {
            foreach ($regexes as $pattern => $regex) {
                if (preg_match($regex, $item)) {
                    return $pattern;
                }
            }
            return $item;
        }, $items);
    }

    private static function multisetDiff(array $old, array $new): array
    {
        $count = [];
        foreach ($old as $i) {
            $count[$i] = ($count[$i] ?? 0) + 1;
        }
        foreach ($new as $i) {
            $count[$i] = ($count[$i] ?? 0) - 1;
        }
        $removed = [];
        $added = [];
        foreach ($count as $item => $n) {
            for (; $n > 0; $n--) {
                $removed[] = (string)$item;
            }
            for (; $n < 0; $n++) {
                $added[] = (string)$item;
            }
        }
        return [$removed, $added];
    }

    private static function issue(string $severity, string $page, string $area, string $message): array
    {
        return compact('severity', 'page', 'area', 'message');
    }
}
