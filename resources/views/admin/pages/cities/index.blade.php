@extends('admin.layouts.master')

@section('title', __('Cities'))

@section('breadcrumb')
    <x-admin.page-header :title="__('Cities')">
        <x-slot name="toolbar">
            <x-admin.index-collapse-toolbar id-prefix="cities" :filter-keys="['city', 'status']" />
        </x-slot>
    </x-admin.page-header>
@endsection

@section('content')
    <div class="collapse show mb-4" id="citiesSummaryCollapse">
        <div class="row g-3">
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Cities')" :value="number_format($stats['total'])"
                    icon="bi-geo-alt-fill" color="primary" />
            </div>
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Available online')" :value="number_format($stats['available_online'])"
                    icon="bi-wifi" color="success" />
            </div>
            <div class="col-sm-6 col-xl-4">
                <x-admin.stats-widget :title="__('Last 7 days')" :value="number_format($stats['recent'])"
                    icon="bi-clock-history" color="info" />
            </div>
        </div>
    </div>

    <div class="collapse mb-4 @if (request()->filled('city') || request()->filled('status')) show @endif"
        id="citiesFiltersCollapse">
        @include('admin.pages.cities.filters')
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @include('admin.pages.cities.list')
        </div>
        <div class="card-footer bg-transparent border-0 d-flex justify-content-center pt-0 pb-4">
            {{ $results->links() }}
        </div>
    </div>
@endsection

@push('css')
    <style>
        .btn-toggle {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
            background-color: var(--bs-secondary-bg, #e9ecef);
            border-radius: 15px;
            border: 1px solid var(--bs-border-color, #dee2e6);
            transition: background-color 0.25s;
            padding: 0;
            cursor: pointer;
        }

        .btn-toggle:focus {
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb, 105, 108, 255), 0.25);
        }

        .btn-toggle.active {
            background-color: var(--bs-primary, #696cff);
            border-color: var(--bs-primary, #696cff);
        }

        .btn-toggle .toggle-on,
        .btn-toggle .toggle-off {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 11px;
            font-weight: 700;
            color: #fff;
            opacity: 0;
        }

        .btn-toggle.active .toggle-on {
            opacity: 1;
        }

        .btn-toggle:not(.active) .toggle-off {
            opacity: 1;
            color: var(--bs-secondary-color, #6c757d);
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
@endpush

@push('scripts')
    <script>
        const successAvailableMsg = @json(__(':cityName is now available online'));
        const successUnavailableMsg = @json(__(':cityName is now unavailable online'));
        const errorMsg = @json(__('Failed to update status'));

        $(document).ready(function() {
            $('.btn-toggle').on('click', function() {
                const button = $(this);
                const url = button.data('url');
                const cityName = button.closest('tr').find('td:eq(1)').text().trim();
                const currentStatus = button.hasClass('active');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            if (!currentStatus) {
                                button.addClass('active');
                                button.attr('aria-pressed', 'true');
                                showAlert('success', successAvailableMsg.replace(':cityName', cityName), @json(__('Success')));
                            } else {
                                button.removeClass('active');
                                button.attr('aria-pressed', 'false');
                                showAlert('success', successUnavailableMsg.replace(':cityName', cityName), @json(__('Success')));
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error('Error updating availability:', xhr.responseText);
                        showAlert('error', errorMsg, @json(__('Error')));
                    }
                });
            });
        });
    </script>
@endpush
