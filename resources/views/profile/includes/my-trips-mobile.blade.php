<div class="d-flex justify-content-between align-items-center mb-3">
    @if (app()->getLocale() == 'ar')
        <i class="fas fa-arrow-right fs-25 text-black" onclick="window.history.back()"></i>
    @else
        <i class="fas fa-arrow-left fs-25 text-black" onclick="window.history.back()"></i>
    @endif


    <p class="m-0 fs-25 text-black">{{ __('Tickets') }}</p>
    <div></div>
</div>

@if ($tickets->where('is_past', false)->count() > 0)
    <div class="mt-3">
        <h2 class="text-black">
            {{ __('Upcomming Tickets') }}
        </h2>
    </div>

    @foreach ($tickets->where('is_past', false) as $ticket)
        <div class="mt-3" style="direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
            <div class="border rounded-7 px-4 pt-2 pb-2 box-shadow">
                <div class="d-flex justify-content-end align-items-end gap-2 mb-3">
                    <span>#{{ $ticket['ticket_id'] . '.' . $ticket['runTrip_id'] }}</span>
                </div>
                <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                    <i class="fa fa-bus fs-18 text-black"></i>
                    <p class="m-0 fs-18 text-black">{{ $ticket['city_from'] }}</p>
                    <span class="fs-10">{{ $ticket['station_from'] }}</span>

                    @if (app()->getLocale() == 'ar')
                        <i class="fas fa-arrow-left fs-18 text-black"></i>
                    @else
                        <i class="fas fa-arrow-right fs-18 text-black"></i>
                    @endif
                    <p class="m-0 fs-18 text-black">{{ $ticket['city_to'] }}</p>
                    <span class="fs-10">{{ $ticket['station_to'] }}</span>
                </div>

                <div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa fa-calendar text-black"></i>
                        <p class="m-0">
                            {{ __('Trip Date') }}: {{ $ticket['date'] }}
                        </p>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa fa-calendar text-black"></i>
                        <p class="m-0">
                            {{ __('Trip Time') }}: {{ $ticket['time'] }}
                        </p>
                        {{-- Counter till trip time --}}

                    </div>
                    @php
                        $now = now();
                        $tripTime = $ticket['trip_time'];
                        $tripDate = $ticket['date'];
                        $diffDay = (int) $now->diffInDays($tripDate);
                        $diff = $now->diff($tripTime);
                    @endphp
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-clock text-black"></i>
                        <p class="m-0">
                            {{ __('Remaining') }}:
                            @if ($diffDay > 0)
                                {{ $diffDay }} {{ __('Days') }}
                            @endif
                            @if ($diff->h > 0)
                                {{ $diff->h }} {{ __('Hours') }}
                            @endif
                            @if ($diff->i > 0)
                                {{ $diff->i }} {{ __('Minutes') }}
                            @endif
                        </p>
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="{{ asset('images/car-seat.png') }}" alt="seat">
                        <p class="m-0">
                            {{ __('Seat Number') }}: {{ implode(' . ', $ticket['seats']) }}
                        </p>
                        {{-- <div class="vip">
                            vip
                        </div> --}}
                    </div>

                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-wallet text-black"></i>
                        <p class="m-0">
                            {{ __('Price') }}: {{ $ticket['price'] }} {{ __('EGP') }}
                        </p>

                        @if ($ticket['reserv_type'] === 'PAID')
                            <span class="badge bg-success">{{ __('Paid') }}</span>
                        @elseif($ticket['reserv_type'] == 'NEW' || $ticket['reserv_type'] == 'New')
                            <span class="badge bg-primary">{{ __('Not Paid') }}</span>
                        @elseif($ticket['reserv_type'] === 'FAILED')
                            <span class="badge bg-danger">{{ __('Not Paid') }}</span>
                        @elseif($ticket['reserv_type'] === 'EXPIRED')
                            <span class="badge bg-secondary">{{ __('Not Paid') }}</span>
                        @endif
                        @php
                            $createdAt = \Carbon\Carbon::parse($ticket['created_at']);
                            $isWithinHour = $createdAt->diffInMinutes(now()) < 60;
                        @endphp
                        @if ($isWithinHour && ($ticket['reserv_type'] == 'NEW' || $ticket['reserv_type'] == 'New'))
                            <div class="alert alert-info mb-0 py-1 px-2" style="font-size: 0.8rem;">
                                {{ __("Payment may take up to 1 hour to process. Don't worry!") }}
                            </div>
                        @endif

                    </div>

                    {{-- 
                    <div class="mb-2 d-flex justify-content-end align-items-center gap-2">
                        <div>
                            <a href="edit-tickets.html">
                                <button class="btn btn-success rounded-6">
                                    <span>{{ __('Edit') }}</span>
                                    <i class="fas fa-pen-to-square mx-1"></i>
                                </button>
                            </a>
                        </div>
                        <div>
                            <a href="cancel-tickets.html">
                                <button class="btn btn-outline-danger rounded-6">
                                    <span>{{ __('Cancel') }}</span>
                                    <i class="fas fa-xmark mx-1"></i>
                                </button>
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    @endforeach
@endif

@if ($tickets->where('is_past', true)->count() > 0)
    <div class="mt-3">
        <h2 class="text-black">
            {{ __('Recent Tickets') }}
        </h2>
    </div>

    @foreach ($tickets->where('is_past', true) as $ticket)
        <div class="mt-3" style="direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
            <div class="border rounded-7 px-4 pt-2 pb-2 box-shadow">
                <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                    <i class="fa fa-bus fs-18 text-black"></i>
                    <p class="m-0 fs-18 text-black">{{ $ticket['city_from'] }}</p>
                    <span class="fs-10">{{ $ticket['station_from'] }}</span>
                    <i class="fas fa-arrow-left fs-18 text-black"></i>
                    <p class="m-0 fs-18 text-black">{{ $ticket['city_to'] }}</p>
                    <span class="fs-10">{{ $ticket['station_to'] }}</span>
                </div>

                <div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fa fa-calendar text-black"></i>
                        <p class="m-0">
                            {{ __('Trip Time') }}: {{ $ticket['time'] }}
                        </p>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="{{ asset('images/car-seat.png') }}" alt="seat">
                        <p class="m-0">
                            {{ __('Seat Number') }}: {{ implode(' . ', $ticket['seats']) }}
                        </p>
                        {{-- <div class="vip">
                            vip
                        </div> --}}
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-wallet text-black"></i>
                        <p class="m-0">
                            {{ __('Price') }}: {{ $ticket['price'] }} {{ __('EGP') }}
                        </p>
                    </div>

                    {{-- <div class="mb-2 d-flex justify-content-end align-items-center gap-2">
                        <div>
                            <button class="btn btn-main rounded-6">
                                <span>{{ __('Rebook') }}</span>
                                <i class="fa-solid fa-arrows-rotate mx-1"></i>
                            </button>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    @endforeach
@endif
