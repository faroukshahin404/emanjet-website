<div class="tab-pane fade show @if (request()->has('tap')) {{ request()->tap == 'trips' ? 'active' : '' }} @else active @endif"
    id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
    <h2>رحلاتي</h2>
    @if ($tickets->where('is_past', false)->count() > 0)
        <h6>رحلاتي القادمة</h6>

        @foreach ($tickets->where('is_past', false) as $ticket)
            <div class="d-flex justify-content-between mb-2">

                <div class="passenger-place  w-100 rounded-8 px-3 py-3">
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <!-- bus icon  -->
                        <div class="bus-box">
                            <i class="fa fa-bus"></i>
                        </div>

                        <!-- from -->
                        <div class="d-flex flex-column align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="m-0 text-black">{{ $ticket['city_from'] }}</h6>
                            </div>
                            <div>
                                <p class="m-0">
                                    {{ $ticket['station_from'] }}
                                </p>
                            </div>
                        </div>
                        <!-- circle -->
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="green-circle"></div>
                            <div class="line"></div>
                            <div class="red-circle"></div>
                        </div>
                        <!-- to  -->
                        <div class="d-flex flex-column align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="m-0 text-black">{{ $ticket['city_to'] }}</h6>
                            </div>
                            <div>
                                <p class="m-0">
                                    {{ $ticket['station_to'] }}
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <i class="fas fa-calendar text-black"></i>
                            <span class="text-black">موعد الرحلة:</span>
                            <span>{{ $ticket['time'] }}</span>
                        </div>
                        <div class="d-flex justify-content-start align-items-center gap-1">
                            <img src="{{ asset('images/car-seat.png') }}" alt="car-seat">
                            <span class="text-black">رقم الكرسي:</span>

                            @if (is_array($ticket['seats']))
                                <span>{{ implode(' . ', $ticket['seats']) }}</span>
                                {{-- <div>
                                <p class="m-0 text-white bg-main text-center vip">vip</p>
                            </div> --}}
                            @endif
                        </div>
                        <div>
                            <i class="fas fa-wallet text-black"></i>
                            <span class="text-black">سعر الرحلة:</span>
                            <span>{{ $ticket['price'] }} جنية</span>
                        </div>
                    </div>

                    {{-- <div class="d-flex justify-content-center gap-3 align-items-center mt-4">
            <div>
                <span class="text-black">تعديل والغاء الحجز يتطلب رسوم 10 جنيه</span>
            </div>
            <div>
                <button class="btn-reserve">
                    تعديل الحجز
                    <i class="fas fa-pen-to-square"></i>
                </button>
            </div>
            <div>
                <button class="btn-reserve btn-cancel">
                    الغاء الحجز
                    <i class="fas fa-pen-to-square"></i>
                </button>
            </div>
        </div> --}}

                </div>

                <div class="passenger-info w-50 rounded-8 px-3 py-3">
                    <h5 class="text-black mb-3">بيانات المسافر</h5>
                    <p class="mb-1"><strong class="text-black">الاسم:</strong>{{ $ticket['user_name'] }}</p>
                    <p><strong class="text-black">رقم الهاتف:</strong>{{ $ticket['user_phone'] }}</p>
                </div>

            </div>
        @endforeach
    @endif
    @if ($tickets->where('is_past', true)->count() > 0)
        <div class="mt-4 text-black">
            <h5>رحلاتي السابقة</h5>
        </div>

        @foreach ($tickets->where('is_past', true) as $ticket)
            <div class="d-flex justify-content-between mb-2">

                <div class="passenger-place  w-100 rounded-8 px-3 py-3">
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <!-- bus icon  -->
                        <div class="bus-box">
                            <i class="fa fa-bus"></i>
                        </div>

                        <!-- from -->
                        <div class="d-flex flex-column align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="m-0 text-black">{{ $ticket['city_from'] }}</h6>
                            </div>
                            <div>
                                <p class="m-0">
                                    {{ $ticket['station_from'] }}
                                </p>
                            </div>
                        </div>
                        <!-- circle -->
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="green-circle"></div>
                            <div class="line"></div>
                            <div class="red-circle"></div>
                        </div>
                        <!-- to  -->
                        <div class="d-flex flex-column align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <h6 class="m-0 text-black">{{ $ticket['city_to'] }}</h6>
                            </div>
                            <div>
                                <p class="m-0">
                                    {{ $ticket['station_to'] }}
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <i class="fas fa-calendar text-black"></i>
                            <span class="text-black">موعد الرحلة:</span>
                            <span>{{ $ticket['time'] }}</span>
                        </div>
                        <div class="d-flex justify-content-start align-items-center gap-1">
                            <img src="{{ asset('images/car-seat.png') }}" alt="car-seat">
                            <span class="text-black">رقم الكرسي:</span>
                            <span>{{ implode(' . ', $ticket['seats']) }}</span>
                            {{-- <div>
                            <p class="m-0 text-white bg-main text-center vip">vip</p>
                        </div> --}}
                        </div>
                        <div>
                            <i class="fas fa-wallet text-black"></i>
                            <span class="text-black">سعر الرحلة:</span>
                            <span>{{ $ticket['price'] }} جنية</span>
                        </div>
                    </div>
                    {{-- 
                <div class="d-flex justify-content-center gap-3 align-items-center mt-4">
                    <div>
                        <span class="text-black">تعديل والغاء الحجز يتطلب رسوم 10 جنيه</span>
                    </div>
                    <div>
                        <button class="btn-reserve">
                            تعديل الحجز
                            <i class="fas fa-pen-to-square"></i>
                        </button>
                    </div>
                    <div>
                        <button class="btn-reserve btn-cancel">
                            الغاء الحجز
                            <i class="fas fa-pen-to-square"></i>
                        </button>
                    </div>
                </div> --}}

                </div>

                <div class="passenger-info w-50 rounded-8 px-3 py-3">
                    <h5 class="text-black mb-3">بيانات المسافر</h5>
                    <p class="mb-1"><strong class="text-black">الاسم:</strong>{{ $ticket['user_name'] }}</p>
                    <p><strong class="text-black">رقم الهاتف:</strong>{{ $ticket['user_phone'] }}</p>
                </div>

            </div>
        @endforeach
    @endif
</div>
