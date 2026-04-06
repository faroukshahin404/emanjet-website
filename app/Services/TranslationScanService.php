<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Finds __(), trans(), @lang(), etc. across the app and compares with ar.json (ov-er style).
 * Uses quote-aware regex so apostrophes inside strings (e.g. Don't) do not break extraction.
 */
class TranslationScanService
{
    /**
     * PHP / generic patterns: first group = string contents (with escapes resolved later).
     *
     * @var array<int, string>
     */
    private array $contentPatterns = [
        '/__\(\s*"((?:\\\\.|[^"\\\\])*)"/',
        "/__\(\s*'((?:\\\\.|[^'\\\\])*)'/",
        '/trans\(\s*"((?:\\\\.|[^"\\\\])*)"/',
        "/trans\(\s*'((?:\\\\.|[^'\\\\])*)'/",
        '/@lang\(\s*"((?:\\\\.|[^"\\\\])*)"/',
        "/@lang\(\s*'((?:\\\\.|[^'\\\\])*)'/",
        '/Lang::get\(\s*"((?:\\\\.|[^"\\\\])*)"/',
        "/Lang::get\(\s*'((?:\\\\.|[^'\\\\])*)'/",
        '/trans_choice\(\s*"((?:\\\\.|[^"\\\\])*)"/',
        "/trans_choice\(\s*'((?:\\\\.|[^'\\\\])*)'/",
    ];

    /**
     * Blade-only prefixes before __().
     *
     * @var array<int, string>
     */
    private array $bladeContentPatterns = [
        '/\{\{\s*__\(\s*"((?:\\\\.|[^"\\\\])*)"/',
        "/\{\{\s*__\(\s*'((?:\\\\.|[^'\\\\])*)'/",
        '/\{\!\!\s*__\(\s*"((?:\\\\.|[^"\\\\])*)"/',
        "/\{\!\!\s*__\(\s*'((?:\\\\.|[^'\\\\])*)'/",
        '/@json\(__\(\s*"((?:\\\\.|[^"\\\\])*)"/',
        "/@json\(__\(\s*'((?:\\\\.|[^'\\\\])*)'/",
    ];

    /**
     * @return array<string, mixed>
     */
    public function loadArabicTranslations(): array
    {
        $path = resource_path('lang/ar.json');
        if (! File::exists($path)) {
            return [];
        }

        $data = json_decode(File::get($path), true);

        return is_array($data) ? $data : [];
    }

    /**
     * @return array<string, mixed>
     */
    public function loadEnglishJson(): array
    {
        $path = resource_path('lang/en.json');
        if (! File::exists($path)) {
            return [];
        }

        $data = json_decode(File::get($path), true);

        return is_array($data) ? $data : [];
    }

    /**
     * @return list<string>
     */
    public function extractKeysFromContent(string $content, bool $isBlade): array
    {
        if ($isBlade) {
            $content = $this->stripBladeComments($content);
        }

        $patterns = $isBlade
            ? array_merge($this->contentPatterns, $this->bladeContentPatterns)
            : $this->contentPatterns;

        $keys = [];
        foreach ($patterns as $pattern) {
            if (preg_match_all($pattern, $content, $m)) {
                foreach ($m[1] as $raw) {
                    $key = $this->normalizeKey(stripslashes($raw));
                    if ($key !== null) {
                        $keys[] = $key;
                    }
                }
            }
        }

        return $keys;
    }

    /**
     * All translation string keys used in the project (unique).
     *
     * @return list<string>
     */
    public function collectKeysFromProject(): array
    {
        $keys = [];

        foreach ($this->scanDirectories() as $dir) {
            if (! is_dir($dir)) {
                continue;
            }
            foreach ($this->iterateProjectFiles($dir) as $file) {
                $content = File::get($file);
                $isBlade = str_contains($file, '.blade.php');
                foreach ($this->extractKeysFromContent($content, $isBlade) as $key) {
                    $keys[$key] = true;
                }
            }
        }

        return array_keys($keys);
    }

    /**
     * Keys used in code but missing from ar.json.
     *
     * @return list<string>
     */
    public function findMissingArabicKeys(): array
    {
        $ar = $this->loadArabicTranslations();
        $used = $this->collectKeysFromProject();

        $missing = [];
        foreach ($used as $key) {
            if (! array_key_exists($key, $ar)) {
                $missing[] = $key;
            }
        }
        sort($missing);

        return $missing;
    }

    /**
     * @return list<array{key: string, file: string, line: int}>
     */
    public function findMissingWithLocations(): array
    {
        $ar = $this->loadArabicTranslations();
        $found = [];

        foreach ($this->scanDirectories() as $dir) {
            if (! is_dir($dir)) {
                continue;
            }
            foreach ($this->iterateProjectFiles($dir) as $file) {
                $content = File::get($file);
                $isBlade = str_contains($file, '.blade.php');
                $relative = str_replace(base_path(), '', $file);

                foreach ($this->extractKeysFromContent($content, $isBlade) as $key) {
                    if (array_key_exists($key, $ar)) {
                        continue;
                    }
                    $line = $this->findKeyLine($content, $key);
                    $found[] = [
                        'key' => $key,
                        'file' => $relative,
                        'line' => $line,
                    ];
                }
            }
        }

        return $found;
    }

    /**
     * Merge keys from en.json into ar.json when missing (value = English string as placeholder).
     *
     * @return array{added: int, keys: list<string>}
     */
    public function mergeEnglishJsonIntoArabic(): array
    {
        $arPath = resource_path('lang/ar.json');
        $ar = $this->loadArabicTranslations();
        $en = $this->loadEnglishJson();
        $addedKeys = [];

        foreach ($en as $key => $value) {
            if (! is_string($key)) {
                continue;
            }
            if (! array_key_exists($key, $ar)) {
                $ar[$key] = is_string($value) ? $value : $key;
                $addedKeys[] = $key;
            }
        }

        $this->writeJsonSorted($arPath, $ar);

        return ['added' => count($addedKeys), 'keys' => $addedKeys];
    }

    /**
     * Append keys from scan that are missing in ar.json; value defaults to the key (for manual translation).
     *
     * @return array{added: int, keys: list<string>}
     */
    public function appendScannedMissingUsingKeyAsPlaceholder(): array
    {
        $arPath = resource_path('lang/ar.json');
        $ar = $this->loadArabicTranslations();
        $missing = $this->findMissingArabicKeys();
        $addedKeys = [];

        foreach ($missing as $key) {
            $ar[$key] = $key;
            $addedKeys[] = $key;
        }

        $this->writeJsonSorted($arPath, $ar);

        return ['added' => count($addedKeys), 'keys' => $addedKeys];
    }

    private function findKeyLine(string $content, string $key): int
    {
        $pos = strpos($content, $key);
        if ($pos === false) {
            return 1;
        }

        return substr_count(substr($content, 0, $pos), "\n") + 1;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function writeJsonSorted(string $path, array $data): void
    {
        ksort($data, SORT_STRING);
        File::put($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)."\n");
    }

    /**
     * @return list<string>
     */
    private function scanDirectories(): array
    {
        return [
            base_path('app'),
            resource_path('views'),
            base_path('routes'),
        ];
    }

    /**
     * @return \Generator<int, string>
     */
    private function iterateProjectFiles(string $root): \Generator
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if (! $file->isFile()) {
                continue;
            }
            $path = $file->getPathname();
            if ($this->shouldSkipPath($path)) {
                continue;
            }
            if ($file->getExtension() !== 'php') {
                continue;
            }
            yield $path;
        }
    }

    private function shouldSkipPath(string $path): bool
    {
        $needles = [DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR.'node_modules'.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR.'bootstrap'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR];

        foreach ($needles as $n) {
            if (str_contains($path, $n)) {
                return true;
            }
        }

        return false;
    }

    private function stripBladeComments(string $content): string
    {
        return preg_replace('/\{\{--.*?--\}\}/s', '', $content) ?? $content;
    }

    private function normalizeKey(string $key): ?string
    {
        $key = trim($key);
        if ($key === '') {
            return null;
        }
        if (str_contains($key, '$')) {
            return null;
        }
        if (str_contains($key, '{{')) {
            return null;
        }
        if ($key === '...') {
            return null;
        }

        return $key;
    }

    /**
     * True if the string contains any Arabic script character (typical Arabic translation keys wrongly passed to __()).
     */
    public function stringContainsArabicScript(string $value): bool
    {
        return preg_match('/\p{Arabic}/u', $value) === 1;
    }

    /**
     * Unique translation keys used in the project whose key string itself contains Arabic (should be refactored to English keys).
     *
     * @return list<string>
     */
    public function findArabicScriptKeysInProject(): array
    {
        $out = [];
        foreach ($this->collectKeysFromProject() as $key) {
            if ($this->stringContainsArabicScript($key)) {
                $out[] = $key;
            }
        }
        sort($out);

        return $out;
    }

    /**
     * Every occurrence of a translation call whose key contains Arabic script, with file and line for refactoring.
     *
     * @return list<array{key: string, file: string, line: int}>
     */
    public function findArabicScriptKeysWithLocations(): array
    {
        $found = [];

        foreach ($this->scanDirectories() as $dir) {
            if (! is_dir($dir)) {
                continue;
            }
            foreach ($this->iterateProjectFiles($dir) as $file) {
                $content = File::get($file);
                $isBlade = str_contains($file, '.blade.php');
                $relative = str_replace(base_path(), '', $file);
                $relative = str_replace(DIRECTORY_SEPARATOR, '/', $relative);

                foreach ($this->extractKeysFromContent($content, $isBlade) as $key) {
                    if (! $this->stringContainsArabicScript($key)) {
                        continue;
                    }
                    $line = $this->findKeyLine($content, $key);
                    $found[] = [
                        'key' => $key,
                        'file' => $relative,
                        'line' => $line,
                    ];
                }
            }
        }

        usort($found, function (array $a, array $b): int {
            return [$a['file'], $a['line'], $a['key']] <=> [$b['file'], $b['line'], $b['key']];
        });

        return $found;
    }

    /**
     * Lines in PHP/Blade (under scan directories) that contain Arabic script anywhere — not only inside __().
     * Line numbers match the file on disk.
     *
     * @param  bool  $includeCommentOnlyLines  When false, skips lines that are only // or block-comment (* /) style lines.
     * @return list<array{file: string, line: int, snippet: string}>
     */
    public function findHardcodedArabicLines(bool $includeCommentOnlyLines = false): array
    {
        $found = [];

        foreach ($this->scanDirectories() as $dir) {
            if (! is_dir($dir)) {
                continue;
            }
            foreach ($this->iterateProjectFiles($dir) as $file) {
                $content = File::get($file);
                $relative = str_replace(base_path(), '', $file);
                $relative = str_replace(DIRECTORY_SEPARATOR, '/', $relative);

                $lines = explode("\n", $content);
                foreach ($lines as $idx => $line) {
                    if (! $this->stringContainsArabicScript($line)) {
                        continue;
                    }
                    if (! $includeCommentOnlyLines && $this->isCommentOnlySourceLine($line)) {
                        continue;
                    }
                    $found[] = [
                        'file' => $relative,
                        'line' => $idx + 1,
                        'snippet' => $this->trimSnippetForReport($line),
                    ];
                }
            }
        }

        usort($found, function (array $a, array $b): int {
            return [$a['file'], $a['line']] <=> [$b['file'], $b['line']];
        });

        return $found;
    }

    /**
     * True when the line is only a comment marker (no code before Arabic). Lines like "code(); // عربي" are NOT skipped.
     */
    private function isCommentOnlySourceLine(string $line): bool
    {
        $t = trim($line);
        if ($t === '' || $t === '*/') {
            return false;
        }

        if (preg_match('/^\/\//', $t)) {
            return true;
        }

        if (preg_match('/^\/\*\*?$/', $t) || $t === '/*' || preg_match('/^\/\*\s/', $t)) {
            return true;
        }

        if (preg_match('/^\*\/\s*$/', $t)) {
            return true;
        }

        if (preg_match('/^\*\s/', $t) || $t === '*') {
            return true;
        }

        return false;
    }

    /**
     * @return string UTF-8 safe trim for table / JSON output
     */
    private function trimSnippetForReport(string $line, int $maxChars = 220): string
    {
        $s = str_replace(["\r", "\t"], ['', ' '], trim($line));
        if (mb_strlen($s) > $maxChars) {
            return mb_substr($s, 0, $maxChars).'…';
        }

        return $s;
    }
}
