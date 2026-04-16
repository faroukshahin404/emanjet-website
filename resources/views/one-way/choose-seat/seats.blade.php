<div class="col-md-7 mb-4">
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
            <!-- SVG Steering Wheel -->
            <svg class="steering-icon" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="5" />
                <circle cx="50" cy="50" r="10" fill="currentColor" />
                <line x1="50" y1="5" x2="50" y2="40" stroke="currentColor" stroke-width="5" />
                <line x1="10" y1="75" x2="42" y2="58" stroke="currentColor" stroke-width="5" />
                <line x1="90" y1="75" x2="58" y2="58" stroke="currentColor" stroke-width="5" />
            </svg>
        </div>

        <div class="row g-0 justify-content-center" style="max-width: {{(@$busType->width??4) * 65}}px;">
            @foreach ($seats as $seat)
                @if ($seat['type'] == 1)
                    <div class="chair-number">
                        <input type="checkbox" 
                               data-price="{{ $seat['price'] }}" 
                               data-name="{{ $seat['name'] }}"
                               data-seat-id="{{ $seat['tripSeat_id'] }}" 
                               id="chair{{ $seat['tripSeat_id'] }}"
                               class="chair-checkbox" 
                               {{ $seat['available'] ? '' : 'disabled' }}>
                        <label for="chair{{ $seat['tripSeat_id'] }}">
                            {{ $seat['name'] }}
                        </label>
                    </div>
                @else
                    <div style="width: 64px; height: 64px;"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>

