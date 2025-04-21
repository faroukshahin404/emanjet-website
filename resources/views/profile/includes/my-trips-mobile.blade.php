<div class="d-flex justify-content-between align-items-center mb-3">
    <a href="index.html">
        <i class="fas fa-arrow-right fs-25 text-black"></i>
    </a>
    <p class="m-0 fs-25 text-black">التذاكر</p>
    <div></div>
</div>

@if ($tickets->where('is_past', false)->count() > 0)
    <div class="mt-3">
        <h2 class="text-black">
            التذاكر الحالية
        </h2>
    </div>

    @foreach ($tickets->where('is_past', false) as $ticket)
        <div class="mt-3">
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
                            وقت المغادرة: {{ $ticket['time'] }}
                        </p>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="{{ asset('images/car-seat.png') }}" alt="seat">
                        <p class="m-0">
                            رقم المقعد: {{ implode(' . ', $ticket['seats']) }}
                        </p>
                        {{-- <div class="vip">
                            vip
                        </div> --}}
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-wallet text-black"></i>
                        <p class="m-0">
                            السعر: {{ $ticket['price'] }} جنيه مصري
                        </p>
                    </div>
{{-- 
                    <div class="mb-2 d-flex justify-content-end align-items-center gap-2">
                        <div>
                            <a href="edit-tickets.html">
                                <button class="btn btn-success rounded-6">
                                    <span>تعديل</span>
                                    <i class="fas fa-pen-to-square mx-1"></i>
                                </button>
                            </a>
                        </div>
                        <div>
                            <a href="cancel-tickets.html">
                                <button class="btn btn-outline-danger rounded-6">
                                    <span>الغاء</span>
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
            التذاكر الأخيرة
        </h2>
    </div>

    @foreach ($tickets->where('is_past', true) as $ticket)
        <div class="mt-3">
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
                            وقت المغادرة: {{ $ticket['time'] }}
                        </p>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <img src="{{ asset('images/car-seat.png') }}" alt="seat">
                        <p class="m-0">
                            رقم المقعد: {{ implode(' . ', $ticket['seats']) }}
                        </p>
                        {{-- <div class="vip">
                            vip
                        </div> --}}
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="fas fa-wallet text-black"></i>
                        <p class="m-0">
                            السعر: {{ $ticket['price'] }} جنيه مصري
                        </p>
                    </div>

                    {{-- <div class="mb-2 d-flex justify-content-end align-items-center gap-2">
                        <div>
                            <button class="btn btn-main rounded-6">
                                <span>اعادة حجز</span>
                                <i class="fa-solid fa-arrows-rotate mx-1"></i>
                            </button>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    @endforeach
@endif