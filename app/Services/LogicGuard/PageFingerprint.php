<?php

namespace App\Services\LogicGuard;

use DOMDocument;
use DOMElement;
use DOMXPath;

class PageFingerprint
{
    private const PRESENTATIONAL_DATA = ['data-bs-placement', 'data-bs-custom-class'];

    private const INLINE_EVENTS = [
        'onclick', 'onchange', 'onsubmit', 'oninput', 'onkeyup', 'onkeydown', 'onblur', 'onfocus', 'onload',
    ];

    public static function fromHtml(string $html, array $hookClasses): array
    {
        $html = self::normalizeHtml($html);

        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">' . $html, LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_COMPACT);
        libxml_clear_errors();
        $xp = new DOMXPath($dom);

        return [
            'title' => self::squash($xp->evaluate('string(//title)')),
            'forms' => self::forms($xp),
            'fields' => self::fields($xp),
            'actions' => self::actions($xp),
            'links' => self::links($xp),
            'ids' => self::ids($xp),
            'data' => self::dataAttributes($xp),
            'events' => self::events($xp),
            'vue' => self::vueComponents($xp),
            'scripts' => self::scripts($xp),
            'hooks' => self::hooks($xp, $hookClasses),
            'text' => self::texts($xp),
        ];
    }

    public static function normalizeHtml(string $html): string
    {
        if (preg_match('/<meta[^>]+name=["\']?csrf-token["\']?[^>]+content=["\']?([A-Za-z0-9]{20,})/i', $html, $m)) {
            $html = str_replace($m[1], '{CSRF}', $html);
        }
        $html = preg_replace('/_token=[A-Za-z0-9]{20,}/', '_token={CSRF}', $html);
        $html = preg_replace('#(/build/assets/[A-Za-z0-9_.-]+?)-[A-Za-z0-9_-]{8}\.(js|css)#', '$1-#.$2', $html);

        $html = preg_replace('/\?\d{9,11}(?=["\'\s&>])/', '?{ts}', $html);

        return preg_replace_callback('/<[a-zA-Z][^<>]*>/', function ($tag) {
            return preg_replace(
                ['/(\s):([a-zA-Z][\w.-]*)=/', '/(\s)@([a-zA-Z][\w.:-]*)=/', '/(\s)v-on:([a-zA-Z][\w.-]*)=/', '/(\s)v-bind:([a-zA-Z][\w.-]*)=/'],
                ['$1vbind--$2=', '$1von--$2=', '$1von--$2=', '$1vbind--$2='],
                $tag[0]
            );
        }, $html);
    }

    private static function forms(DOMXPath $xp): array
    {
        $out = [];
        foreach ($xp->query('//form') as $form) {
            $out[] = implode(' | ', [
                'id=' . $form->getAttribute('id'),
                'action=' . $form->getAttribute('action'),
                'method=' . strtolower($form->getAttribute('method') ?: 'get'),
                'enctype=' . $form->getAttribute('enctype'),
                'fields=' . count(self::controlsIn($xp, $form)),
            ]);
        }
        sort($out);
        return $out;
    }

    private static function controlsIn(DOMXPath $xp, DOMElement $root): \DOMNodeList
    {
        return $xp->query('.//input | .//select | .//textarea', $root);
    }

    private static function fields(DOMXPath $xp): array
    {
        $out = [];
        foreach ($xp->query('//input | //select | //textarea') as $el) {
            $name = $el->getAttribute('name');
            $id = $el->getAttribute('id');
            if ($name === '' && $id === '' && !$el->hasAttribute('class')) {
                continue;
            }
            $tag = strtolower($el->tagName);
            $type = $tag === 'input' ? strtolower($el->getAttribute('type') ?: 'text') : $tag;
            $parts = [
                'form=' . self::owningForm($el),
                $tag,
                'type=' . $type,
                'name=' . $name,
                'id=' . $id,
            ];
            if (in_array($type, ['hidden', 'checkbox', 'radio', 'submit', 'button'], true) || $el->hasAttribute('value')) {
                $parts[] = 'value=' . $el->getAttribute('value');
            }
            if ($tag === 'textarea') {
                $parts[] = 'value=' . md5(trim($el->textContent));
            }
            foreach (['required', 'multiple', 'checked', 'disabled', 'readonly', 'min', 'max', 'step', 'pattern', 'accept', 'maxlength', 'form', 'list', 'autocomplete'] as $attr) {
                if ($el->hasAttribute($attr)) {
                    $parts[] = $attr . '=' . $el->getAttribute($attr);
                }
            }
            if ($tag === 'select') {
                $opts = [];
                foreach ($xp->query('.//option', $el) as $opt) {
                    $opts[] = $opt->getAttribute('value') . ($opt->hasAttribute('selected') ? '*' : '');
                }
                $parts[] = 'options=[' . implode(',', $opts) . ']';
            }

            if ($name === '' && $id === '') {
                $parts[] = 'anon';
            }
            $out[] = implode(' ', $parts);
        }
        sort($out);
        return $out;
    }

    private static function owningForm(DOMElement $el): string
    {
        if ($el->hasAttribute('form')) {
            return '#' . $el->getAttribute('form');
        }
        for ($n = $el->parentNode; $n instanceof DOMElement; $n = $n->parentNode) {
            if (strtolower($n->tagName) === 'form') {
                return ($n->getAttribute('id') ?: '') . '@' . ($n->getAttribute('action') ?: '');
            }
        }
        return '-';
    }

    private static function actions(DOMXPath $xp): array
    {
        $out = [];
        foreach ($xp->query('//button') as $el) {
            $out[] = implode(' ', [
                'form=' . self::owningForm($el),
                'type=' . strtolower($el->getAttribute('type') ?: 'submit'),
                'name=' . $el->getAttribute('name'),
                'value=' . $el->getAttribute('value'),
                'id=' . $el->getAttribute('id'),
            ]);
        }
        sort($out);
        return $out;
    }

    private static function links(DOMXPath $xp): array
    {
        $out = [];
        foreach ($xp->query('//a[@href]') as $el) {
            $out[] = trim($el->getAttribute('href')) . ($el->hasAttribute('target') ? ' target=' . $el->getAttribute('target') : '');
        }
        sort($out);
        return $out;
    }

    private static function ids(DOMXPath $xp): array
    {
        $out = [];
        foreach ($xp->query('//*[@id]') as $el) {
            $out[] = $el->getAttribute('id');
        }
        sort($out);
        return $out;
    }

    private static function dataAttributes(DOMXPath $xp): array
    {
        $out = [];
        foreach ($xp->query('//*[@*[starts-with(name(), "data-")]]') as $el) {
            foreach ($el->attributes as $attr) {
                if (str_starts_with($attr->name, 'data-') && !in_array($attr->name, self::PRESENTATIONAL_DATA, true)) {
                    $out[] = $attr->name . '=' . self::squash($attr->value);
                }
            }
        }
        sort($out);
        return $out;
    }

    private static function events(DOMXPath $xp): array
    {
        $out = [];
        $query = implode(' | ', array_map(fn($e) => '//*[@' . $e . ']', self::INLINE_EVENTS));
        foreach ($xp->query($query) as $el) {
            foreach (self::INLINE_EVENTS as $event) {
                if ($el->hasAttribute($event)) {
                    $out[] = $event . '=' . preg_replace('/\s+/', '', $el->getAttribute($event));
                }
            }
        }
        sort($out);
        return $out;
    }

    private static function vueComponents(DOMXPath $xp): array
    {
        $out = [];
        foreach ($xp->query('//*[contains(local-name(), "-")]') as $el) {
            $attrs = [];
            foreach ($el->attributes as $attr) {
                if ($attr->name === 'class' || $attr->name === 'style') {
                    continue;
                }
                $attrs[] = $attr->name . '=' . md5(self::squash($attr->value));
            }
            sort($attrs);
            $out[] = strtolower($el->tagName) . ' ' . implode(' ', $attrs);
        }
        sort($out);
        return $out;
    }

    private static function scripts(DOMXPath $xp): array
    {
        $out = [];
        foreach ($xp->query('//script') as $el) {
            if ($el->hasAttribute('src')) {
                $out[] = 'src=' . $el->getAttribute('src');
            } else {
                $out[] = 'inline=' . md5(preg_replace('/\s+/', '', $el->textContent));
            }
        }
        sort($out);
        return $out;
    }

    private static function hooks(DOMXPath $xp, array $hookClasses): array
    {
        $out = [];
        foreach ($hookClasses as $class) {
            $count = $xp->query('//*[contains(concat(" ", normalize-space(@class), " "), " ' . $class . ' ")]')->length;
            if ($count > 0) {
                $out[$class] = $count;
            }
        }
        ksort($out);
        return $out;
    }

    private static function texts(DOMXPath $xp): array
    {
        $out = [];
        foreach ($xp->query('//body//text()[not(ancestor::script) and not(ancestor::style) and not(ancestor::textarea)]') as $node) {
            $t = self::squash($node->nodeValue);
            if ($t !== '' && !preg_match('/^[\p{P}\p{S}\d\s]+$/u', $t)) {
                $out[] = $t;
            }
        }
        foreach ($xp->query('//*[@placeholder or @title or @aria-label or @data-bs-title or @alt]') as $el) {
            foreach (['placeholder', 'title', 'aria-label', 'data-bs-title', 'alt'] as $attr) {
                if ($el->hasAttribute($attr) && ($v = self::squash($el->getAttribute($attr))) !== '') {
                    $out[] = '[' . $attr . '] ' . $v;
                }
            }
        }
        sort($out);
        return $out;
    }

    private static function squash(?string $s): string
    {
        return trim(preg_replace('/\s+/u', ' ', (string)$s));
    }
}
