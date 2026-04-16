<!-- Outbound Seats -->
<div class="col-md-7 mb-4">
    <div class="mb-5">
        <h5 class="text-center text-black fw-bold mb-4"><i class="fa fa-arrow-right text-main me-2"></i>{{ __('Departure Seats') }}</h5>
        
        <div class="d-flex justify-content-center flex-wrap gap-4 mb-4">
            <div class="legend-item">
                <div class="your-chair"></div>
                <span>{{ __('Your Seat') }}</span>
            </div>
            <div class="legend-item">
                <div class="available-chair"></div>
                <span>{{ __('Available') }}</span>
            </div>
            <div class="legend-item">
                <div class="reserved-chair"></div>
                <span>{{ __('Reserved') }}</span>
            </div>
        </div>

        <div class="bus-cabin">
            <div class="bus-front">
                <svg class="steering-icon" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="5" />
                    <circle cx="50" cy="50" r="10" fill="currentColor" />
                    <line x1="50" y1="5" x2="50" y2="40" stroke="currentColor" stroke-width="5" />
                    <line x1="10" y1="75" x2="42" y2="58" stroke="currentColor" stroke-width="5" />
                    <line x1="90" y1="75" x2="58" y2="58" stroke="currentColor" stroke-width="5" />
                </svg>
            </div>

            <div class="row g-0 justify-content-center" style="max-width: {{(@$busType->width??4) * 65}}px;">
                @foreach ($goSeats as $seat)
                    @if ($seat['type'] == 1)
                        <div class="chair-number">
                            <input type="checkbox" data-price="{{ $seat['price'] }}"
                                data-seat-id="{{ $seat['tripSeat_id'] }}" data-name="{{ $seat['name'] }}"
                                id="go{{ $seat['tripSeat_id'] }}" class="chair-checkbox go"
                                {{ $seat['available'] ? '' : 'disabled' }}>
                            <label for="go{{ $seat['tripSeat_id'] }}">{{ $seat['name'] }}</label>
                        </div>
                    @else
                        <div style="width: 64px; height: 64px;"></div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- Return Seats -->
    <div class="mt-5">
        <h5 class="text-center text-black fw-bold mb-4"><i class="fa fa-arrow-left text-main me-2"></i>{{ __('Return Seats') }}</h5>
        
        <div class="bus-cabin">
            <div class="bus-front">
                <svg class="steering-icon" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="5" />
                    <circle cx="50" cy="50" r="10" fill="currentColor" />
                    <line x1="50" y1="5" x2="50" y2="40" stroke="currentColor" stroke-width="5" />
                    <line x1="10" y1="75" x2="42" y2="58" stroke="currentColor" stroke-width="5" />
                    <line x1="90" y1="75" x2="58" y2="58" stroke="currentColor" stroke-width="5" />
                </svg>
            </div>

            <div class="row g-0 justify-content-center" style="max-width: {{(@$busType->width??4) * 65}}px;">
                @foreach ($returnSeats as $seat)
                    @if ($seat['type'] == 1)
                        <div class="chair-number">
                            <input type="checkbox" data-price="{{ $seat['round_price'] - $seat['price'] }}"
                                data-seat-id="{{ $seat['tripSeat_id'] }}" data-name="{{ $seat['name'] }}"
                                id="ret{{ $seat['tripSeat_id'] }}" class="chair-checkbox return"
                                {{ $seat['available'] ? '' : 'disabled' }}>
                            <label for="ret{{ $seat['tripSeat_id'] }}">{{ $seat['name'] }}</label>
                        </div>
                    @else
                        <div style="width: 64px; height: 64px;"></div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

