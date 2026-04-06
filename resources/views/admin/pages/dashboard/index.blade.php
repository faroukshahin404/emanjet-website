@extends('admin.layouts.master')

@section('title', __('Dashboard'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box box-body dashboard-hero-box mb-25">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-15">
                    <div>
                        <span class="badge badge-primary mb-10">{{ __('Real-time overview') }}</span>
                        <h3 class="mb-5">@lang('SuperJet Operations Dashboard')</h3>
                        <p class="mb-0 text-fade">{{ __('A unified snapshot for bookings, revenue, trips, and customers.') }}</p>
                    </div>
                    <a href="{{ route('admin.destinations.index') }}" class="btn btn-primary">
                        <i data-feather="plus-circle" class="me-5"></i>{{ __('Manage Destinations') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-12">
            <div class="box box-body dashboard-kpi-box bg-info pull-up">
                <div class="d-flex justify-content-between align-items-center mb-10">
                    <div>
                        <p class="mb-0 text-uppercase">{{ __('Total Reservations') }}</p>
                        <h2 class="mb-0">{{ number_format($stats['total_reservations']) }}</h2>
                    </div>
                    <span class="dashboard-kpi-icon"><i data-feather="calendar"></i></span>
                </div>
                <small class="text-white-70">{{ $stats['today_reservations'] }} @lang('new today')</small>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-12">
            <div class="box box-body dashboard-kpi-box bg-success pull-up">
                <div class="d-flex justify-content-between align-items-center mb-10">
                    <div>
                        <p class="mb-0 text-uppercase">{{ __('Total Revenue') }}</p>
                        <h2 class="mb-0">{{ number_format($stats['total_revenue'], 2) }} EGP</h2>
                    </div>
                    <span class="dashboard-kpi-icon"><i data-feather="dollar-sign"></i></span>
                </div>
                <small class="text-white-70">@lang('Total earnings')</small>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-12">
            <div class="box box-body dashboard-kpi-box bg-warning pull-up">
                <div class="d-flex justify-content-between align-items-center mb-10">
                    <div>
                        <p class="mb-0 text-uppercase">{{ __('Active Trips') }}</p>
                        <h2 class="mb-0">{{ number_format($stats['active_trips']) }}</h2>
                    </div>
                    <span class="dashboard-kpi-icon"><i data-feather="truck"></i></span>
                </div>
                <small class="text-white-70">@lang('Available for booking')</small>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-12">
            <div class="box box-body dashboard-kpi-box bg-dark pull-up">
                <div class="d-flex justify-content-between align-items-center mb-10">
                    <div>
                        <p class="mb-0 text-uppercase">{{ __('Total Users') }}</p>
                        <h2 class="mb-0">{{ number_format($stats['total_users']) }}</h2>
                    </div>
                    <span class="dashboard-kpi-icon"><i data-feather="users"></i></span>
                </div>
                <small class="text-white-70">@lang('Registered customers')</small>
            </div>
        </div>

        <div class="col-xl-4 col-12">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">{{ __('Performance Snapshot') }}</h4>
                </div>
                <div class="box-body">
                    @php
                        $reservations = max((int) ($stats['total_reservations'] ?? 0), 0);
                        $todayReservations = max((int) ($stats['today_reservations'] ?? 0), 0);
                        $activeTrips = max((int) ($stats['active_trips'] ?? 0), 0);
                        $totalUsers = max((int) ($stats['total_users'] ?? 0), 0);
                        $dailyBookingsRate = $reservations > 0 ? min(100, (int) round(($todayReservations / $reservations) * 100)) : 0;
                        $tripUtilizationRate = min(100, $activeTrips * 10);
                        $userEngagementRate = $totalUsers > 0 ? min(100, (int) round(($reservations / $totalUsers) * 100)) : 0;
                    @endphp

                    <div class="mb-20">
                        <div class="d-flex justify-content-between mb-5">
                            <span>{{ __('Daily booking rate') }}</span>
                            <strong>{{ $dailyBookingsRate }}%</strong>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $dailyBookingsRate }}%"></div>
                        </div>
                    </div>
                    <div class="mb-20">
                        <div class="d-flex justify-content-between mb-5">
                            <span>{{ __('Trip utilization') }}</span>
                            <strong>{{ $tripUtilizationRate }}%</strong>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $tripUtilizationRate }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between mb-5">
                            <span>{{ __('User engagement') }}</span>
                            <strong>{{ $userEngagementRate }}%</strong>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $userEngagementRate }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-12">
            <div class="box">
                <div class="box-header with-border d-flex justify-content-between align-items-center">
                    <h4 class="box-title mb-0">{{ __('Latest Booking Stream') }}</h4>
                    <span class="badge badge-info">{{ __('Live') }}</span>
                </div>
                <div class="box-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="dashboard-table-head">
                                <tr>
                                    <th>@lang('ID')</th>
                                    <th>@lang('Customer')</th>
                                    <th>@lang('Trip')</th>
                                    <th>@lang('Route')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_bookings->take(5) as $booking)
                                    <tr>
                                        <td><strong>#{{ $booking->id }}</strong></td>
                                        <td>{{ $booking->user->name ?? __('Guest') }}</td>
                                        <td>{{ $booking->runTrip->name ?? __('Trip N/A') }}</td>
                                        <td>{{ $booking->stationFrom->name ?? '-' }} -> {{ $booking->stationTo->name ?? '-' }}</td>
                                        <td>{{ number_format($booking->total, 2) }} EGP</td>
                                        <td>
                                            @if($booking->payment_status == 'paid' || $booking->total == 0)
                                                <span class="badge badge-success-light">{{ __('Completed') }}</span>
                                            @else
                                                <span class="badge badge-warning-light">{{ __('Pending') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-20 text-fade">@lang('No bookings found.')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">@lang('All Recent Bookings')</h4>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>@lang('Booking ID')</th>
                                    <th>@lang('Customer')</th>
                                    <th>@lang('Trip & Route')</th>
                                    <th>@lang('Date & Time')</th>
                                    <th>@lang('Total Amount')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_bookings as $booking)
                                    <tr>
                                        <td>#{{ $booking->id }}</td>
                                        <td>
                                            <div class="fw-600">{{ $booking->user->name ?? __('Guest') }}</div>
                                            <small class="text-fade">{{ $booking->user->phone ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-600">{{ $booking->runTrip->name ?? __('Trip N/A') }}</div>
                                            <small class="text-fade">
                                                {{ $booking->stationFrom->name ?? '-' }} -> {{ $booking->stationTo->name ?? '-' }}
                                            </small>
                                        </td>
                                        <td>
                                            <div>{{ $booking->created_at->format('M d, Y') }}</div>
                                            <small class="text-fade">{{ $booking->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td>{{ number_format($booking->total, 2) }} EGP</td>
                                        <td>
                                            @if($booking->payment_status == 'paid' || $booking->total == 0)
                                                <span class="badge badge-success">@lang('Completed')</span>
                                            @else
                                                <span class="badge badge-warning">@lang('Pending')</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-fade py-20">
                                            @lang('No bookings found.')
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .dashboard-hero-box {
            background: linear-gradient(120deg, rgba(85, 110, 230, 0.12) 0%, rgba(62, 92, 221, 0.05) 100%);
            border: 1px solid #e8ebf5;
        }

        .dashboard-kpi-box {
            border: 0;
            border-radius: 12px;
        }

        .dashboard-kpi-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.22);
        }

        .dashboard-table-head th {
            background-color: #f8fafd;
            border-bottom: 1px solid #edf0f6;
        }
    </style>
@endpush
