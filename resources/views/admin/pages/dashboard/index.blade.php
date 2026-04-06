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
                            <h3 class="fw-bold text-white mb-2">@lang('SuperJet Operations Dashboard')</h3>
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
            <x-admin.stats-widget :title="__('Total Reservations')"
                :value="number_format($stats['total_reservations'])" icon="bi-calendar-check-fill" color="info"
                :today="$stats['today_reservations']" />
        </div>
        <div class="col-xl-3 col-md-6">
            <x-admin.stats-widget :title="__('Total Revenue')"
                :value="number_format($stats['total_revenue'], 2) . ' EGP'" icon="bi-currency-exchange" color="success" />
        </div>
        <div class="col-xl-3 col-md-6">
            <x-admin.stats-widget :title="__('Active Trips')" :value="number_format($stats['active_trips'])"
                icon="bi-bus-front-fill" color="warning" />
        </div>
        <div class="col-xl-3 col-md-6">
            <x-admin.stats-widget :title="__('Total Users')" :value="number_format($stats['total_users'])"
                icon="bi-people-fill" color="primary" />
        </div>

        @php
            $reservations = max((int) ($stats['total_reservations'] ?? 0), 0);
            $todayReservations = max((int) ($stats['today_reservations'] ?? 0), 0);
            $activeTrips = max((int) ($stats['active_trips'] ?? 0), 0);
            $totalUsers = max((int) ($stats['total_users'] ?? 0), 0);
            $dailyBookingsRate = $reservations > 0 ? min(100, (int) round(($todayReservations / $reservations) * 100)) : 0;
            $tripUtilizationRate = min(100, $activeTrips * 10);
            $userEngagementRate = $totalUsers > 0 ? min(100, (int) round(($reservations / $totalUsers) * 100)) : 0;
        @endphp

        <div class="col-xl-4 col-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 pb-0 pt-4 px-4 bg-transparent">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="bi bi-speedometer2 text-primary me-2"></i>{{ __('Performance Snapshot') }}
                    </h5>
                </div>
                <div class="card-body pt-3">
                    <div class="mb-4">
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">{{ __('Daily booking rate') }}</span>
                            <strong>{{ $dailyBookingsRate }}%</strong>
                        </div>
                        <div class="progress" style="height: 0.5rem;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ $dailyBookingsRate }}%;" aria-valuenow="{{ $dailyBookingsRate }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">{{ __('Trip utilization') }}</span>
                            <strong>{{ $tripUtilizationRate }}%</strong>
                        </div>
                        <div class="progress" style="height: 0.5rem;">
                            <div class="progress-bar bg-warning" role="progressbar"
                                style="width: {{ $tripUtilizationRate }}%;" aria-valuenow="{{ $tripUtilizationRate }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-muted">{{ __('User engagement') }}</span>
                            <strong>{{ $userEngagementRate }}%</strong>
                        </div>
                        <div class="progress" style="height: 0.5rem;">
                            <div class="progress-bar bg-success" role="progressbar"
                                style="width: {{ $userEngagementRate }}%;" aria-valuenow="{{ $userEngagementRate }}"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-12">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 d-flex flex-wrap justify-content-between align-items-center gap-2 pt-4 px-4 pb-0 bg-transparent">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="bi bi-lightning-charge text-info me-2"></i>{{ __('Latest Booking Stream') }}
                    </h5>
                    <span class="badge bg-label-info">{{ __('Live') }}</span>
                </div>
                <div class="card-body p-0 pt-3">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
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
                                        <td class="small">{{ $booking->stationFrom->name ?? '-' }} →
                                            {{ $booking->stationTo->name ?? '-' }}</td>
                                        <td>{{ number_format($booking->total, 2) }} EGP</td>
                                        <td>
                                            @if ($booking->payment_status == 'paid' || $booking->total == 0)
                                                <span class="badge bg-label-success">{{ __('Completed') }}</span>
                                            @else
                                                <span class="badge bg-label-warning">{{ __('Pending') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">@lang('No bookings found.')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0 pt-4 px-4 pb-0 bg-transparent">
                    <h5 class="card-title mb-0 fw-bold">
                        <i class="bi bi-list-ul text-primary me-2"></i>@lang('All Recent Bookings')
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered mb-0 align-middle">
                            <thead class="table-light">
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
                                            <div class="fw-semibold">{{ $booking->user->name ?? __('Guest') }}</div>
                                            <small class="text-muted">{{ $booking->user->phone ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $booking->runTrip->name ?? __('Trip N/A') }}</div>
                                            <small class="text-muted">
                                                {{ $booking->stationFrom->name ?? '-' }} →
                                                {{ $booking->stationTo->name ?? '-' }}
                                            </small>
                                        </td>
                                        <td>
                                            <div>{{ $booking->created_at->format('M d, Y') }}</div>
                                            <small class="text-muted">{{ $booking->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td>{{ number_format($booking->total, 2) }} EGP</td>
                                        <td>
                                            @if ($booking->payment_status == 'paid' || $booking->total == 0)
                                                <span class="badge bg-success">{{ __('Completed') }}</span>
                                            @else
                                                <span class="badge bg-warning text-dark">{{ __('Pending') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
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
