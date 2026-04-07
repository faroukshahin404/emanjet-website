<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TranslationScanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Admin translation utilities: JSON APIs to scan project strings vs ar.json, list Arabic-in-code keys, merge tools.
 */
class TranslationController extends Controller
{
    public function __construct(
        private TranslationScanService $scanner
    ) {}

    /**
     * GET /admin/translations — JSON index of available endpoints (no HTML UI).
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'Translation tools are JSON/CLI only. Send Accept: application/json on POST to receive JSON.',
            'get' => [
                'scan' => route('admin.translations.scan'),
                'arabic_keys' => route('admin.translations.arabic-keys'),
                'arabic_text' => route('admin.translations.arabic-text'),
            ],
            'post' => [
                'sync_en' => route('admin.translations.sync-en'),
                'append_scanned' => route('admin.translations.append-scanned'),
            ],
            'cli' => 'php artisan translations:manage',
        ]);
    }

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
     * GET /admin/translations/arabic-keys — keys that contain Arabic text (bad practice; use English keys + ar.json).
     */
    public function arabicKeys(Request $request): JsonResponse
    {
        set_time_limit(120);

        $keys = $this->scanner->findArabicScriptKeysInProject();
        $details = $request->boolean('details')
            ? $this->scanner->findArabicScriptKeysWithLocations()
            : [];

        return response()->json([
            'arabic_key_count' => count($keys),
            'arabic_keys' => $keys,
            'details' => $details,
        ]);
    }

    /**
     * GET /admin/translations/arabic-text — any line with Arabic in scanned PHP/Blade (not limited to __()).
     */
    public function arabicText(Request $request): JsonResponse
    {
        set_time_limit(300);

        $includeComments = $request->boolean('comments');
        $lines = $this->scanner->findHardcodedArabicLines($includeComments);

        return response()->json([
            'line_count' => count($lines),
            'include_comment_only_lines' => $includeComments,
            'lines' => $lines,
        ]);
    }

    /**
     * POST /admin/translations/sync-en — add any key from en.json that is not yet in ar.json (value = English text).
     */
    public function syncFromEnglish(Request $request): JsonResponse|RedirectResponse
    {
        $result = $this->scanner->mergeEnglishJsonIntoArabic();

        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'message' => 'Merged missing keys from resources/lang/en.json into ar.json.',
                'added_count' => $result['added'],
                'added_keys' => $result['keys'],
            ]);
        }

        return redirect()
            ->route('admin.dashboard.index')
            ->with('success', __('Merged :count keys from en.json into ar.json.', ['count' => $result['added']]));
    }

    /**
     * POST /admin/translations/append-scanned — add keys found by scan but missing in ar.json; value = key (translate later).
     */
    public function appendScanned(Request $request): JsonResponse|RedirectResponse
    {
        if (! $request->boolean('confirm')) {
            if ($this->shouldReturnJson($request)) {
                return response()->json([
                    'message' => 'Set confirm=1 (or JSON {"confirm":true}) to write placeholders to ar.json.',
                ], 422);
            }

            return redirect()
                ->route('admin.dashboard.index')
                ->with('warning', __('POST with confirm=1 and Accept: application/json to append placeholders to ar.json, or use php artisan translations:manage.'));
        }

        $result = $this->scanner->appendScannedMissingUsingKeyAsPlaceholder();

        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'message' => 'Missing keys appended to ar.json (value equals key until you translate).',
                'added_count' => $result['added'],
                'added_keys' => $result['keys'],
            ]);
        }

        return redirect()
            ->route('admin.dashboard.index')
            ->with('success', __('Appended :count placeholder keys to ar.json.', ['count' => $result['added']]));
    }

    private function shouldReturnJson(Request $request): bool
    {
        return $request->wantsJson() || $request->expectsJson();
    }
}
