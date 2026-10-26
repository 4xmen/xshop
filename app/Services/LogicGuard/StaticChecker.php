<?php

namespace App\Services\LogicGuard;

use Symfony\Component\Process\Process;

class StaticChecker
{
    private const PROTECTED_PATHS = [
        'app', 'routes', 'config', 'database/migrations', 'database/seeders', 'database/factories',
        'bootstrap/app.php', 'bootstrap/providers.php', 'composer.json', 'composer.lock', 'lang', 'resources/lang',
    ];

    private const OWN_PATHS = ['app/Services/LogicGuard/', 'app/Console/Commands/LogicGuard.php'];

    public function __construct(private string $basePath, private string $base)
    {
    }

    public function check(): array
    {
        $this->git(['rev-parse', '--verify', $this->base]);

        return array_merge(
            $this->protectedPaths(),
            $this->plainJavaScript(),
            $this->vueScripts(),
            $this->bladeLogic(),
        );
    }

    private function protectedPaths(): array
    {
        $issues = [];
        foreach ($this->changedFiles(self::PROTECTED_PATHS) as $file => $status) {
            if ($this->isOwnFile($file)) {
                continue;
            }
            $issues[] = $this->issue('error', 'protected', $file, "server-side file {$status} (design work must not touch it)");
        }
        return $issues;
    }

    private function plainJavaScript(): array
    {
        $issues = [];
        foreach ($this->changedFiles(['resources/js']) as $file => $status) {
            if (!str_ends_with($file, '.js')) {
                continue;
            }

            $severity = $status === 'added' ? 'warning' : 'error';
            $issues[] = $this->issue($severity, 'javascript', $file, "JavaScript file {$status}");
        }
        return $issues;
    }

    private function vueScripts(): array
    {
        $issues = [];
        foreach ($this->changedFiles(['resources/js']) as $file => $status) {
            if (!str_ends_with($file, '.vue')) {
                continue;
            }
            if ($status !== 'modified') {
                $issues[] = $this->issue($status === 'added' ? 'warning' : 'error', 'vue', $file, "Vue component {$status}");
                continue;
            }
            $before = $this->vueScript($this->show($file));
            $after = $this->vueScript((string)@file_get_contents($this->basePath . '/' . $file));
            if ($before !== $after) {
                $issues[] = $this->issue('error', 'vue', $file, '<script> block changed');
            }
        }
        return $issues;
    }

    private function vueScript(string $source): string
    {
        preg_match_all('#<script\b[^>]*>(.*?)</script>#is', $source, $m);
        return preg_replace('/\s+/', '', implode("\n", $m[1]));
    }

    private function bladeLogic(): array
    {
        $before = [];
        $after = [];
        $where = [];

        foreach ($this->changedFiles(['resources/views']) as $file => $status) {
            if (!str_ends_with($file, '.blade.php')) {
                continue;
            }
            $old = $status === 'added' ? '' : $this->show($file);
            $new = $status === 'deleted' ? '' : (string)@file_get_contents($this->basePath . '/' . $file);
            foreach (self::bladeTokens($old) as $t) {
                $before[$t] = ($before[$t] ?? 0) + 1;
                $where[$t][$file] = true;
            }
            foreach (self::bladeTokens($new) as $t) {
                $after[$t] = ($after[$t] ?? 0) + 1;
                $where[$t][$file] = true;
            }
        }

        $issues = [];
        foreach ($before as $token => $count) {
            $now = $after[$token] ?? 0;
            if ($now < $count) {
                $issues[] = $this->issue('error', 'blade', implode(', ', array_keys($where[$token])),
                    'logic removed (' . $count . ' → ' . $now . '): ' . $token);
            }
        }
        foreach ($after as $token => $count) {
            $was = $before[$token] ?? 0;
            if ($count > $was) {
                $issues[] = $this->issue('warning', 'blade', implode(', ', array_keys($where[$token])),
                    'logic added (' . $was . ' → ' . $count . '): ' . $token);
            }
        }
        return $issues;
    }

    public static function bladeTokens(string $source): array
    {
        $source = preg_replace('/\{\{--.*?--\}\}/s', '', $source);
        $tokens = [];

        preg_match_all('/\{!!(.*?)!!\}|\{\{(.*?)\}\}/s', $source, $m, PREG_SET_ORDER);
        foreach ($m as $match) {
            $raw = $match[1] !== '' ? '{!!' . $match[1] . '!!}' : '{{' . ($match[2] ?? '') . '}}';
            $tokens[] = preg_replace('/\s+/', '', $raw);
        }
        $source = preg_replace('/\{!!.*?!!\}|\{\{.*?\}\}/s', '', $source);

        $offset = 0;
        while (preg_match('/(?<![\w@])@([a-zA-Z]+)/', $source, $dm, PREG_OFFSET_CAPTURE, $offset)) {
            $name = $dm[1][0];
            $pos = $dm[0][1] + strlen($dm[0][0]);
            $args = '';
            $rest = substr($source, $pos);
            if (preg_match('/^\s*\(/', $rest, $lead)) {
                $start = $pos + strlen($lead[0]) - 1;
                $depth = 0;
                $len = strlen($source);
                for ($i = $start; $i < $len; $i++) {
                    $ch = $source[$i];
                    if ($ch === '(') {
                        $depth++;
                    } elseif ($ch === ')') {
                        $depth--;
                        if ($depth === 0) {
                            break;
                        }
                    }
                }
                $args = substr($source, $start, $i - $start + 1);
                $pos = $i + 1;
            }

            if (!in_array(strtolower($name), ['media', 'keyframes', 'import', 'font', 'supports', 'charset', 'example', 'gmail'], true)) {
                $tokens[] = '@' . $name . preg_replace('/\s+/', '', $args);
            }
            $offset = $pos;
        }

        return $tokens;
    }

    private function changedFiles(array $paths): array
    {
        $files = [];
        $out = $this->git(array_merge(['diff', '--name-status', '--no-renames', $this->base, '--'], $paths));
        foreach (preg_split('/\R/', trim($out)) as $line) {
            if ($line === '') {
                continue;
            }
            [$code, $file] = preg_split('/\t+/', $line, 2);
            $files[$file] = match ($code[0]) {
                'A' => 'added',
                'D' => 'deleted',
                default => 'modified',
            };
        }
        $untracked = $this->git(array_merge(['ls-files', '--others', '--exclude-standard', '--'], $paths));
        foreach (preg_split('/\R/', trim($untracked)) as $file) {
            if ($file !== '') {
                $files[$file] = 'added';
            }
        }
        ksort($files);
        return $files;
    }

    private function isOwnFile(string $file): bool
    {
        foreach (self::OWN_PATHS as $own) {
            if (str_starts_with($file, $own)) {
                return true;
            }
        }
        return false;
    }

    private function show(string $file): string
    {
        return $this->git(['show', $this->base . ':' . $file]);
    }

    private function git(array $args): string
    {
        $process = new Process(array_merge(['git'], $args), $this->basePath);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new \RuntimeException('git ' . implode(' ', $args) . ' failed: ' . trim($process->getErrorOutput()));
        }
        return $process->getOutput();
    }

    private function issue(string $severity, string $area, string $file, string $message): array
    {
        return compact('severity', 'area', 'file', 'message');
    }
}
