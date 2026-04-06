@extends('admin.layouts.master')

@section('title', __('Translation Tools'))

@section('breadcrumb')
    <x-admin.page-header :title="__('Translation Tools')" />
@endsection

@section('content')
    <div class="alert alert-info border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-info-circle me-2"></i>
        {{ __('Arabic keys used as translation strings: replace them with English keys in PHP/Blade, then add the Arabic text only inside resources/lang/ar.json.') }}
    </div>

    <div class="card border-0 shadow-sm mb-4" id="hardcoded-arabic">
        <div class="card-header bg-white border-bottom d-flex flex-wrap align-items-center gap-2 py-3">
            <i class="bi bi-chat-left-text text-danger"></i>
            <h5 class="mb-0 fw-semibold">{{ __('Arabic text anywhere in PHP/Blade') }}</h5>
            <span class="badge bg-secondary ms-auto">{{ __(':count lines', ['count' => $hardcodedArabicTotal]) }}</span>
            <a href="{{ route('admin.translations.arabic-text') }}" target="_blank" rel="noopener"
                class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-braces me-1"></i>{{ __('JSON (full list)') }}
            </a>
            <a href="{{ route('admin.translations.arabic-text', ['comments' => 1]) }}" target="_blank" rel="noopener"
                class="btn btn-sm btn-outline-secondary">
                {{ __('JSON + comment lines') }}
            </a>
        </div>
        <div class="card-body border-bottom bg-light py-3">
            <p class="text-muted small mb-0">
                {{ __('Scans app/, resources/views/, and routes/ — not __() only. Full-line // and * doc lines are excluded by default; use “JSON + comment lines” to include them.') }}
            </p>
        </div>
        <div class="card-body p-0">
            @if ($hardcodedArabicTotal === 0)
                <p class="text-muted mb-0 p-4">{{ __('No Arabic script found in scanned files.') }}</p>
            @else
                @if ($hardcodedArabicTruncated)
                    <p class="small text-warning mb-0 px-4 pt-3">
                        {{ __('Showing first 500 rows. Open JSON for the complete list.') }}
                    </p>
                @endif
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-nowrap">{{ __('File') }}</th>
                                <th scope="col" class="text-nowrap">{{ __('Line') }}</th>
                                <th scope="col">{{ __('Snippet') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hardcodedArabicPreview as $row)
                                <tr>
                                    <td class="small font-monospace text-break">{{ $row['file'] }}</td>
                                    <td class="text-nowrap">{{ $row['line'] }}</td>
                                    <td class="text-break font-monospace small" dir="auto">{{ $row['snippet'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4" id="arabic-keys-list">
        <div class="card-header bg-white border-bottom d-flex flex-wrap align-items-center gap-2 py-3">
            <i class="bi bi-translate text-primary"></i>
            <h5 class="mb-0 fw-semibold">{{ __('Arabic script inside __() keys') }}</h5>
            <span class="badge bg-secondary ms-auto">{{ __(':count unique keys', ['count' => count($arabicKeys)]) }}</span>
            <a href="{{ route('admin.translations.arabic-keys', ['details' => 1]) }}" target="_blank" rel="noopener"
                class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-braces me-1"></i>{{ __('JSON (with locations)') }}
            </a>
        </div>
        <div class="card-body p-0">
            @if (count($arabicLocations) === 0)
                <p class="text-muted mb-0 p-4">{{ __('No Arabic script found inside translation keys. Good job.') }}</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-nowrap">{{ __('File') }}</th>
                                <th scope="col" class="text-nowrap">{{ __('Line') }}</th>
                                <th scope="col">{{ __('Key (refactor to English)') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($arabicLocations as $row)
                                <tr>
                                    <td class="small font-monospace text-break">{{ $row['file'] }}</td>
                                    <td class="text-nowrap">{{ $row['line'] }}</td>
                                    <td class="text-break" dir="auto">{{ $row['key'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom d-flex align-items-center gap-2 py-3">
            <i class="bi bi-search text-secondary"></i>
            <h5 class="mb-0 fw-semibold">{{ __('Missing keys scan') }}</h5>
            <a href="{{ route('admin.translations.scan', ['details' => 1]) }}" target="_blank" rel="noopener"
                class="btn btn-sm btn-outline-secondary ms-auto">
                <i class="bi bi-braces me-1"></i>{{ __('Open JSON') }}
            </a>
        </div>
        <div class="card-body">
            <p class="text-muted small mb-0">
                {{ __('Lists keys used in code but not present in ar.json.') }}
            </p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6" id="merge-en">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="bi bi-file-earmark-arrow-down text-success me-2"></i>{{ __('Merge from en.json') }}
                    </h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="text-muted small flex-grow-1">
                        {{ __('Adds keys from resources/lang/en.json into ar.json when missing (value copied from English).') }}
                    </p>
                    <form action="{{ route('admin.translations.sync-en') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-arrow-repeat me-1"></i>{{ __('Run merge') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6" id="append-scanned">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="bi bi-plus-square text-warning me-2"></i>{{ __('Append scanned missing keys') }}
                    </h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="text-muted small flex-grow-1">
                        {{ __('Adds every key used in code but missing from ar.json; value equals the key until you translate.') }}
                    </p>
                    <form action="{{ route('admin.translations.append-scanned') }}" method="POST"
                        onsubmit="return confirm(@json(__('This will modify ar.json. Continue?')));">
                        @csrf
                        <input type="hidden" name="confirm" value="1">
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-plus-lg me-1"></i>{{ __('Append placeholders') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
