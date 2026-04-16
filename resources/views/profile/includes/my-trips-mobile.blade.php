<div class="d-flex justify-content-between align-items-center mb-4 wow animate__animated animate__fadeIn">
    <button type="button" onclick="window.history.back()" class="bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center border-light-subtle" style="width: 40px; height: 40px; border: 1px solid #eee;">
        @if (app()->getLocale() == 'ar')
            <i class="fas fa-arrow-right fs-16 text-black"></i>
        @else
            <i class="fas fa-arrow-left fs-16 text-black"></i>
        @endif
    </button>
    <h5 class="m-0 fw-800 text-black">{{ __('My Tickets') }}</h5>
    <div style="width: 40px;"></div>
</div>

@if ($tickets->where('is_past', false)->count() > 0)
    <div class="mb-3 wow animate__animated animate__fadeIn px-1">
        <span class="text-muted fw-800 overline-text d-block" style="font-size: 9px;">{{ __('UPCOMING TRIPS') }}</span>
    </div>

    @foreach ($tickets->where('is_past', false) as $ticket)
        <div class="bg-white rounded-5 shadow-premium border border-light-subtle p-3 mb-4 wow animate__animated animate__fadeInUp" style="direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted fw-800" style="font-size: 10px;">#{{ $ticket['ticket_id'] . '.' . $ticket['runTrip_id'] }}</span>
                @if ($ticket['reserv_type'] === 'PAID')
                    <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1 fw-800" style="font-size: 8px;">{{ __('Paid') }}</span>
                @else
                    <span class="badge bg-warning-subtle text-warning rounded-pill px-2 py-1 fw-800" style="font-size: 8px;">{{ __('Pending') }}</span>
                @endif
            </div>

            <div class="mb-3 pb-3 border-bottom border-light-subtle">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex flex-column align-items-center">
                        <div class="bg-success rounded-circle" style="width: 8px; height: 8px;"></div>
                        <div class="bg-light" style="width: 2px; height: 20px; margin: 2px 0;"></div>
                        <div class="bg-main rounded-circle" style="width: 8px; height: 8px;"></div>
                    </div>
                    <div class="d-flex flex-column gap-1">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-800 text-black small">{{ $ticket['city_from'] }}</span>
                            <span class="text-muted fw-800" style="font-size: 9px;">({{ $ticket['station_from'] }})</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-800 text-black small">{{ $ticket['city_to'] }}</span>
                            <span class="text-muted fw-800" style="font-size: 9px;">({{ $ticket['station_to'] }})</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <span class="text-muted fw-800 d-block mb-1" style="font-size: 8px;">{{ __('DATE & TIME') }}</span>
                    <span class="text-black fw-800 small d-block" style="font-size: 11px;">{{ $ticket['date'] }} | {{ $ticket['time'] }}</span>
                </div>
                <div class="col-6 text-end">
                    <span class="text-muted fw-800 d-block mb-1" style="font-size: 8px;">{{ __('SEATS') }}</span>
                    <span class="text-black fw-800 small d-block" style="font-size: 11px;">{{ implode(', ', $ticket['seats']) }}</span>
                </div>
            </div>

            @php
                $now = now();
                $tripTime = $ticket['trip_time'];
                $tripDate = $ticket['date'];
                $diffDay = (int) $now->diffInDays($tripDate);
                $diff = $now->diff($tripTime);
            @endphp
            
            <div class="bg-light rounded-pill p-2 d-flex align-items-center justify-content-between px-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-clock text-main fs-12"></i>
                    <span class="fw-800 text-muted" style="font-size: 10px;">{{ __('Remaining') }}:</span>
                    <span class="fw-800 text-black px-1" style="font-size: 11px;">
                        @if ($diffDay > 0) {{ $diffDay }}d @endif
                        @if ($diff->h > 0) {{ $diff->h }}h @endif
                        @if ($diff->i > 0) {{ $diff->i }}m @endif
                    </span>
                </div>
                <span class="fw-800 text-main" style="font-size: 11px;">{{ $ticket['price'] }} {{ __('EGP') }}</span>
            </div>

            @if ($ticket['reserv_type'] == 'NEW' || $ticket['reserv_type'] == 'New')
                @php
                    $createdAt = \Carbon\Carbon::parse($ticket['created_at']);
                    $isWithinHour = $createdAt->diffInMinutes(now()) < 60;
                @endphp
                @if ($isWithinHour)
                    <div class="mt-3 p-2 bg-info-subtle text-info rounded-4 border border-info-subtle wow animate__animated animate__pulse animate__infinite">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-info-circle fs-12"></i>
                            <span class="fw-800" style="font-size: 9px;">{{ __("Processing your payment...") }}</span>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    @endforeach
@endif

@if ($tickets->where('is_past', true)->count() > 0)
    <div class="mb-3 mt-5 wow animate__animated animate__fadeIn px-1">
        <span class="text-muted fw-800 overline-text d-block" style="font-size: 9px;">{{ __('RECENT TICKETS') }}</span>
    </div>

    @foreach ($tickets->where('is_past', true) as $ticket)
        <div class="bg-white rounded-5 shadow-premium border border-light-subtle p-3 mb-4 opacity-75 wow animate__animated animate__fadeInUp" style="direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted fw-800" style="font-size: 10px;">{{ $ticket['date'] }}</span>
                <span class="badge bg-light text-muted rounded-pill px-2 py-1 fw-800 border border-light-subtle" style="font-size: 8px;">{{ __('Completed') }}</span>
            </div>

            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-light text-muted rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                        <i class="fa fa-bus fs-14"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-800 text-black small">{{ $ticket['city_from'] }}</span>
                            <i class="fas fa-long-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} text-muted fs-10 mx-1 opacity-50"></i>
                            <span class="fw-800 text-black small">{{ $ticket['city_to'] }}</span>
                        </div>
                        <span class="text-muted fw-800 d-block" style="font-size: 10px;">
                            {{ implode(', ', $ticket['seats']) }} {{ __('Seats') }} • {{ $ticket['price'] }} {{ __('EGP') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif

@if ($tickets->count() == 0)
    <div class="text-center py-5 wow animate__animated animate__fadeIn">
        <div class="bg-light text-muted rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
            <i class="fas fa-ticket-alt fs-30 opacity-25"></i>
        </div>
        <h6 class="fw-900 text-black mb-1">{{ __('No Tickets Found') }}</h6>
        <p class="text-muted fw-800 small">{{ __('Your booking history will appear here.') }}</p>
        <a href="{{ route('home') }}" class="btn btn-main-outline rounded-pill px-4 py-2 mt-3 fw-800 small">
            {{ __('Book Your First Trip') }}
        </a>
    </div>
@endif
