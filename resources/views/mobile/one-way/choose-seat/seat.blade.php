<div class="col-12 mb-3 chairs">
    <!-- Seat Legend -->
    <div class="bg-white rounded-5 shadow-premium border border-light-subtle p-3 mb-4 wow animate__animated animate__fadeIn">
        <div class="d-flex justify-content-center gap-4">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-main rounded-2" style="width: 12px; height: 12px;"></div>
                <span class="fw-800 text-muted" style="font-size: 10px;">{{ __('Your Seat') }}</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="bg-light border border-light-subtle rounded-2" style="width: 12px; height: 12px;"></div>
                <span class="fw-800 text-muted" style="font-size: 10px;">{{ __('Available') }}</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="bg-dark opacity-10 rounded-2" style="width: 12px; height: 12px;"></div>
                <span class="fw-800 text-muted" style="font-size: 10px;">{{ __('Reserved') }}</span>
            </div>
        </div>
    </div>

    <div class="bus-cabin bg-white rounded-5 shadow-premium border border-light-subtle p-4 mb-4">
        <!-- Bus Front / Driver Section -->
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-dashed border-light-subtle">
            <div class="bg-light rounded-pill px-3 py-1">
                <span class="text-muted fw-800" style="font-size: 10px;">{{ __('Driver') }}</span>
            </div>
            <div class="bg-light text-muted rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                <svg class="steering-icon" viewBox="0 0 100 100" style="width: 20px; height: 20px; opacity: 0.5;">
                    <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="5" />
                    <circle cx="50" cy="50" r="10" fill="currentColor" />
                    <line x1="50" y1="5" x2="50" y2="40" stroke="currentColor" stroke-width="5" />
                    <line x1="10" y1="75" x2="42" y2="58" stroke="currentColor" stroke-width="5" />
                    <line x1="90" y1="75" x2="58" y2="58" stroke="currentColor" stroke-width="5" />
                </svg>
            </div>
        </div>

        <!-- Seats Grid -->
        <div class="row g-2 justify-content-center">
            @foreach ($seats as $seat)
                @if ($seat['type'] == 1)
                    <div class="chair-number" style="width: 48px; height: 48px;">
                        <input type="checkbox"
                            data-price="{{ $seat['price'] }}"
                            data-name="{{ $seat['name'] }}"
                            data-seat-id="{{$seat['tripSeat_id']}}"
                            id="chair{{ $seat['tripSeat_id'] }}"
                            class="chair-checkbox premium-seat-checkbox"
                            {{ $seat['available'] ? '' : 'disabled' }}>
                        <label for="chair{{ $seat['tripSeat_id'] }}" class="fw-800 d-flex align-items-center justify-content-center" style="border-radius: 12px; font-size: 12px; transition: all 0.3s ease;">
                            {{ $seat['name'] }}
                        </label>
                    </div>
                @else
                    <div style="width: 48px; height: 48px;"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>

