<div class="col-12 mb-3 chairs">
    <div class="d-flex justify-content-center flex-wrap gap-3 mb-4">
        <div class="legend-item">
            <div class="your-chair"></div>
            <span class="small">{{ __('Your Seat') }}</span>
        </div>
        <div class="legend-item">
            <div class="available-chair"></div>
            <span class="small">{{ __('Available') }}</span>
        </div>
        <div class="legend-item">
            <div class="reserved-chair"></div>
            <span class="small">{{ __('Reserved') }}</span>
        </div>
    </div>

    <div class="bus-cabin" style="padding: 20px 10px 10px;">
        <div class="bus-front" style="padding-bottom: 10px; margin-bottom: 15px;">
            <svg class="steering-icon" viewBox="0 0 100 100" style="width: 25px; height: 25px;">
                <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="5" />
                <circle cx="50" cy="50" r="10" fill="currentColor" />
                <line x1="50" y1="5" x2="50" y2="40" stroke="currentColor" stroke-width="5" />
                <line x1="10" y1="75" x2="42" y2="58" stroke="currentColor" stroke-width="5" />
                <line x1="90" y1="75" x2="58" y2="58" stroke="currentColor" stroke-width="5" />
            </svg>
        </div>

        <div class="row g-0 justify-content-center" style="max-width: {{(@$busType->width??4) * 60}px;">
            @foreach ($seats as $seat)
                @if ($seat['type'] == 1)
                    <div class="chair-number" style="width: 44px; height: 44px; margin: 5px;">
                        <input type="checkbox"
                            data-price="{{ $seat['price'] }}"
                            data-name="{{ $seat['name'] }}"
                            data-seat-id="{{$seat['tripSeat_id']}}"
                            id="chair{{ $seat['tripSeat_id'] }}"
                            class="chair-checkbox"
                            {{ $seat['available'] ? '' : 'disabled' }}>
                        <label for="chair{{ $seat['tripSeat_id'] }}" style="border-radius: 10px; font-size: 11px;">{{ $seat['name'] }}</label>
                    </div>
                @else
                    <div style="width: 54px; height: 54px;"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>

