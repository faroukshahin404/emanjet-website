<!-- مقاعد الذهاب -->
<div class="col-md-6 mb-4">
    <h5 class="text-center text-black">مقاعد الذهاب</h5>
    <div class="d-flex justify-content-center align-items-center gap-3 mb-2">
        <div class="d-flex align-items-center gap-2">
            <span class="chair-label">كرسيك</span>
            <div class="your-chair"></div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="chair-label">متاح</span>
            <div class="available-chair"></div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="chair-label">محجوز</span>
            <div class="reserved-chair"></div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div class="row mt-2 justify-content-center chairs" style="width: 250px;">
            @foreach ($goSeats as $seat)
                @if ($seat['type'] == 1)
                    <div class="chair-number">
                        <input type="checkbox" data-price="{{ $seat['price'] }}"
                            data-seat-id="{{ $seat['tripSeat_id'] }}" data-name="{{ $seat['name'] }}"
                            id="{{ $seat['tripSeat_id'] }}" class="chair-checkbox go"
                            {{ $seat['available'] ? '' : 'disabled' }}>
                        <label for="{{ $seat['tripSeat_id'] }}">{{ $seat['name'] }}</label>
                    </div>
                @else
                    <div style="width: 50px;"></div>
                @endif
            @endforeach
        </div>
    </div>
    <hr>
    <h5 class="text-center text-black">مقاعد العودة</h5>
    <div class="d-flex justify-content-center align-items-center gap-3 mb-2">
        <div class="d-flex align-items-center gap-2">
            <span class="chair-label">كرسيك</span>
            <div class="your-chair"></div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="chair-label">متاح</span>
            <div class="available-chair"></div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="chair-label">محجوز</span>
            <div class="reserved-chair"></div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div class="row mt-2 justify-content-center chairs" style="width: 250px;">
            @foreach ($returnSeats as $seat)
                @if ($seat['type'] == 1)
                    <div class="chair-number">

                        <input type="checkbox" data-price="{{ $seat['round_price'] - $seat['price'] }}"
                            data-seat-id="{{ $seat['tripSeat_id'] }}" data-name="{{ $seat['name'] }}"
                            id="{{ $seat['tripSeat_id'] }}" class="chair-checkbox return"
                            {{ $seat['available'] ? '' : 'disabled' }}>
                        <label for="{{ $seat['tripSeat_id'] }}">{{ $seat['name'] }}</label>
                    </div>
                @else
                    <div style="width: 50px;"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>
