<!-- Location Bottom Sheet -->
<div id="locationBottomSheet" class="bottom-sheet">
    <div class="bottom-sheet-content">
        <div class="sheet-header p-3 d-flex align-items-center">
            <button type="button" class="btn-back d-none">
                <i class="fas fa-arrow-right"></i>
            </button>
            <div class="search-container flex-grow-1">
                <input type="text" class="form-control" placeholder="{{ __('Search') }}" id="locationSearch">
            </div>
        </div>

        <ul class="location-list main-list">
            @foreach ($cities as $city)
                <li class="location-item" data-city="{{ $city->id }}">
                    <div class="city-header d-flex justify-content-between align-items-center p-3">
                        <span>{{ $city->name }}</span>
                        @if (app()->getLocale() == 'ar')
                            <i class="fas fa-chevron-left toggle-arrow"></i>
                        @else
                            <i class="fas fa-chevron-right toggle-arrow"></i>
                        @endif
                    </div>
                    <ul class="sub-stations" id="{{ $city->id }}-stations">
                        @foreach ($city->stations as $station)
                            <li class="station-item" data-location="{{ $station->id }}">
                                <div class="d-flex align-items-center p-3">
                                    <span>{{ $station->name }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add click event listener to city headers
            const cityHeaders = document.querySelectorAll('.city-header');
            cityHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    // Toggle the display of sub-stations
                    const parent = this.parentElement;
                    const subStations = parent.querySelector('.sub-stations');
                    const arrow = this.querySelector('.toggle-arrow');

                    // Check if the sub-stations are currently visible
                    const isOpen = subStations.style.display === 'block';

                    // Toggle the display
                    subStations.style.display = isOpen ? 'none' : 'block';

                    // Toggle the arrow direction
                    if (isOpen) {
                        // Reset to original direction
                        if (document.dir === 'rtl' || document.documentElement.lang === 'ar') {
                            arrow.classList.remove('fa-chevron-down');
                            arrow.classList.add('fa-chevron-left');
                        } else {
                            arrow.classList.remove('fa-chevron-down');
                            arrow.classList.add('fa-chevron-right');
                        }
                    } else {
                        // Change to down arrow when open
                        arrow.classList.remove('fa-chevron-right', 'fa-chevron-left');
                        arrow.classList.add('fa-chevron-down');
                    }
                });
            });

            // Initially hide all sub-stations
            const subStations = document.querySelectorAll('.sub-stations');
            subStations.forEach(subStation => {
                subStation.style.display = 'none';
            });
        });
    </script>
@endpush
@push('style')
    <style>
        .bottom-sheet {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-height: 80vh;
            overflow-y: auto;
        }

        .location-item,
        .station-item {
            list-style: none;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
        }

        .location-item:hover,
        .station-item:hover {
            background-color: #f8f9fa;
        }

        .toggle-arrow {
            transition: transform 0.3s ease;
        }

        .city-header {
            cursor: pointer;
        }

        .sub-stations {
            padding-left: 20px;
            background-color: #f9f9f9;
        }
    </style>
@endpush
