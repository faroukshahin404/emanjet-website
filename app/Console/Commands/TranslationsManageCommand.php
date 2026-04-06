<?php

namespace App\Console\Commands;

use App\Services\TranslationScanService;
use Illuminate\Console\Command;

class TranslationsManageCommand extends Command
{
    protected $signature = 'translations:manage
                            {action : scan | arabic-keys | arabic-text | sync-en | append-scanned}
                            {--limit=50 : Max rows to print for scan / arabic-keys / arabic-text}
                            {--details : Print file:line for each arabic-keys occurrence}
                            {--comments : For arabic-text: include lines that are only // or * block comments}';

    protected $description = 'Scan missing keys, Arabic inside __(), any Arabic text in PHP/Blade, merge en.json, or append placeholders.';

    public function handle(TranslationScanService $scanner): int
    {
        $action = $this->argument('action');

        return match ($action) {
            'scan' => $this->runScan($scanner),
            'arabic-keys' => $this->runArabicKeys($scanner),
            'arabic-text' => $this->runArabicText($scanner),
            'sync-en' => $this->runSyncEn($scanner),
            'append-scanned' => $this->runAppend($scanner),
            default => $this->invalidAction(),
        };
    }

    private function runScan(TranslationScanService $scanner): int
    {
        $missing = $scanner->findMissingArabicKeys();
        $limit = (int) $this->option('limit');

        $this->info('Missing keys in resources/lang/ar.json: '.count($missing));
        foreach (array_slice($missing, 0, $limit) as $key) {
            $this->line(' - '.$key);
        }
        if (count($missing) > $limit) {
            $this->comment('... and '.(count($missing) - $limit).' more.');
        }

        return self::SUCCESS;
    }

    private function runArabicKeys(TranslationScanService $scanner): int
    {
        $keys = $scanner->findArabicScriptKeysInProject();
        $limit = (int) $this->option('limit');

        $this->warn('These strings are used as translation keys but contain Arabic. Prefer English keys + ar.json values.');
        $this->info('Unique Arabic keys in code: '.count($keys));

        foreach (array_slice($keys, 0, $limit) as $key) {
            $this->line(' - '.$key);
        }
        if (count($keys) > $limit) {
            $this->comment('... and '.(count($keys) - $limit).' more.');
        }

        if ($this->option('details')) {
            $this->newLine();
            $this->info('Occurrences:');
            foreach ($scanner->findArabicScriptKeysWithLocations() as $row) {
                $this->line(sprintf('  %s:%d  %s', $row['file'], $row['line'], $row['key']));
            }
        }

        return self::SUCCESS;
    }

    private function runArabicText(TranslationScanService $scanner): int
    {
        $includeComments = $this->option('comments');
        $lines = $scanner->findHardcodedArabicLines($includeComments);
        $limit = (int) $this->option('limit');

        $this->info('Arabic script in PHP/Blade (excluding resources/lang JSON files).');
        $this->line('Comment-only lines (// and * blocks): '.($includeComments ? 'included' : 'excluded').'.');
        $this->info('Matching lines: '.count($lines));

        foreach (array_slice($lines, 0, $limit) as $row) {
            $this->line(sprintf('%s:%d  %s', $row['file'], $row['line'], $row['snippet']));
        }
        if (count($lines) > $limit) {
            $this->comment('... and '.(count($lines) - $limit).' more. Increase --limit or use GET /admin/translations/arabic-text');
        }

        return self::SUCCESS;
    }

    private function runSyncEn(TranslationScanService $scanner): int
    {
        $result = $scanner->mergeEnglishJsonIntoArabic();
        $this->info('Merged from en.json — added: '.$result['added']);
        foreach ($result['keys'] as $key) {
            $this->line(' + '.$key);
        }

        return self::SUCCESS;
    }

    private function runAppend(TranslationScanService $scanner): int
    {
        if (! $this->confirm('This will add missing scanned keys to ar.json with Arabic placeholder = key. Continue?')) {
            return self::FAILURE;
        }
        $result = $scanner->appendScannedMissingUsingKeyAsPlaceholder();
        $this->info('Appended placeholders — added: '.$result['added']);

        return self::SUCCESS;
    }

    private function invalidAction(): int
    {
        $this->error('Invalid action. Use: scan, arabic-keys, arabic-text, sync-en, or append-scanned.');

        return self::FAILURE;
    }
}
