<?php

namespace App\Console\Commands;

use App\Services\TranslationScanService;
use Illuminate\Console\Command;

class TranslationsManageCommand extends Command
{
    protected $signature = 'translations:manage
                            {action : scan | sync-en | append-scanned}
                            {--limit=50 : Max keys to print for scan}';

    protected $description = 'Scan for missing Arabic JSON keys, merge from en.json, or append scanned keys (placeholders).';

    public function handle(TranslationScanService $scanner): int
    {
        $action = $this->argument('action');

        return match ($action) {
            'scan' => $this->runScan($scanner),
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
        $this->error('Invalid action. Use: scan, sync-en, or append-scanned.');

        return self::FAILURE;
    }
}
