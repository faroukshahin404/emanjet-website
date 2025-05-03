<div class="col-md-6 mb-3">
    <div class="d-flex justify-content-center align-items-center gap-3">
        <div class="d-flex align-items-center gap-2">
            <span class="chair-label">{{ __('Your Seat') }}</span>
            <div class="your-chair"></div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="chair-label">{{ __('Available') }}</span>
            <div class="available-chair"></div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="chair-label">{{ __('Reserved') }}</span>
            <div class="reserved-chair"></div>
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center">
        <div class="row mt-3 justify-content-center chairs" style="width: {{(@$busType->width??5) *50 }}px;">
            @foreach ($seats as $seat)
                @if ($seat['type'] == 1)
                    <div class="chair-number">
                        <input type="checkbox" data-price="{{ $seat['price'] }}" data-name="{{ $seat['name'] }}"
                            data-seat-id="{{ $seat['tripSeat_id'] }}" id="chair{{ $seat['tripSeat_id'] }}"
                            class="chair-checkbox" {{ $seat['available'] ? '' : 'disabled' }}>
                        <label for="chair{{ $seat['tripSeat_id'] }}">{{ $seat['name'] }}</label>
                    </div>
                @else
                    <div style="width: 50px;"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>
