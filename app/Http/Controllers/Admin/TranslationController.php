<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TranslationScanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Admin translation utilities (inspired by ov-er TranslationController): scan project strings vs ar.json.
 */
class TranslationController extends Controller
{
    public function __construct(
        private TranslationScanService $scanner
    ) {}

    /**
     * GET /admin/translations/scan — JSON list of keys used in code but missing from ar.json.
     */
    public function scan(Request $request): JsonResponse
    {
        set_time_limit(120);

        $missing = $this->scanner->findMissingArabicKeys();
        $withLocations = $request->boolean('details')
            ? $this->scanner->findMissingWithLocations()
            : [];

        return response()->json([
            'missing_count' => count($missing),
            'missing_keys' => $missing,
            'details' => $withLocations,
        ]);
    }

    /**
     * POST /admin/translations/sync-en — add any key from en.json that is not yet in ar.json (value = English text).
     */
    public function syncFromEnglish(): JsonResponse
    {
        $result = $this->scanner->mergeEnglishJsonIntoArabic();

        return response()->json([
            'message' => 'Merged missing keys from resources/lang/en.json into ar.json.',
            'added_count' => $result['added'],
            'added_keys' => $result['keys'],
        ]);
    }

    /**
     * POST /admin/translations/append-scanned — add keys found by scan but missing in ar.json; value = key (translate later).
     */
    public function appendScanned(Request $request): JsonResponse
    {
        if (! $request->boolean('confirm')) {
            return response()->json([
                'message' => 'Set confirm=1 (or JSON {"confirm":true}) to write placeholders to ar.json.',
            ], 422);
        }

        $result = $this->scanner->appendScannedMissingUsingKeyAsPlaceholder();

        return response()->json([
            'message' => 'Missing keys appended to ar.json (value equals key until you translate).',
            'added_count' => $result['added'],
            'added_keys' => $result['keys'],
        ]);
    }
}
