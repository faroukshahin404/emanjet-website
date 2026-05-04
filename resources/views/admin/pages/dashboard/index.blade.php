@extends('admin.layouts.master')

@section('title', __('Dashboard'))

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm overflow-hidden"
                style="background: linear-gradient(135deg, var(--primary) 0%, color-mix(in srgb, var(--primary) 75%, #000) 100%);">
                <div class="card-body p-4 p-md-5 text-white">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div>
                            <span class="badge bg-white bg-opacity-25 text-white mb-2">{{ __('Real-time overview') }}</span>
                            <h3 class="fw-bold text-white mb-2">@lang('Eman Jet Operations Dashboard')</h3>
                            <p class="mb-0 opacity-90">
                                {{ __('A unified snapshot for bookings, revenue, trips, and customers.') }}</p>
                        </div>
                        <a href="{{ route('admin.destinations.index') }}" class="btn btn-light text-primary fw-semibold">
                            <i class="bi bi-plus-circle me-1"></i>{{ __('Manage Destinations') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <x-admin.stats-widget :title="__('Cities')"
                :value="number_format($stats['total_cities'])" icon="bi bi-geo-alt-fill" color="primary" />
        </div>
        <div class="col-xl-3 col-md-6">
            <x-admin.stats-widget :title="__('Destinations')"
                :value="number_format($stats['total_destinations'])" icon="bi bi-map-fill" color="success" />
        </div>
        <div class="col-xl-3 col-md-6">
            <x-admin.stats-widget :title="__('Blog Posts')" :value="number_format($stats['total_blogs'])"
                icon="bi bi-journal-text" color="info" />
        </div>
        <div class="col-xl-3 col-md-6">
            <x-admin.stats-widget :title="__('FAQs')" :value="number_format($stats['total_faqs'])"
                icon="bi bi-patch-question-fill" color="warning" />
        </div>

        <div class="col-xl-4 col-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 pb-0 pt-4 px-4 bg-transparent">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="bi bi-chat-left-text-fill text-primary me-2"></i>{{ __('Inquiry Statistics') }}
                    </h5>
                </div>
                <div class="card-body pt-3">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">{{ __('Total Messages') }}</span>
                            <strong>{{ $stats['total_contacts'] }}</strong>
                        </div>
                        <div class="progress" style="height: 0.5rem;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ min(100, $stats['total_contacts'] * 5) }}%;"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">{{ __('Testimonials') }}</span>
                            <strong>{{ $stats['total_testimonials'] }}</strong>
                        </div>
                        <div class="progress" style="height: 0.5rem;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ min(100, $stats['total_testimonials'] * 10) }}%;"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">{{ __('System Pages') }}</span>
                            <strong>{{ $stats['total_pages'] }}</strong>
                        </div>
                        <div class="progress" style="height: 0.5rem;">
                            <div class="progress-bar bg-info" role="progressbar"
                                style="width: {{ min(100, $stats['total_pages'] * 5) }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 d-flex flex-wrap justify-content-between align-items-center gap-2 pt-4 px-4 pb-0 bg-transparent">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="bi bi-envelope-paper text-info me-2"></i>{{ __('Recent Messages') }}
                    </h5>
                </div>
                <div class="card-body p-0 pt-3">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Phone')</th>
                                    <th>@lang('Message')</th>
                                    <th>@lang('Date')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_messages as $message)
                                    <tr>
                                        <td><div class="fw-semibold">{{ $message->name }}</div></td>
                                        <td>{{ $message->mobile }}</td>
                                        <td>
                                            <div class="text-truncate text-muted small" style="max-width: 250px;">
                                                {{ $message->message }}
                                            </div>
                                        </td>
                                        <td class="small">{{ $message->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-5">@lang('No messages found.')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="fw-bold mb-2">{{ __('Need help managing your content?') }}</h4>
                            <p class="mb-0 opacity-90">{{ __('You can easily update pages, SEO settings, and blogs from the sidebar menu. All changes reflect instantly on the website.') }}</p>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <a href="{{ route('admin.pages.index') }}" class="btn btn-light px-4">
                                {{ __('Go to Page Management') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
