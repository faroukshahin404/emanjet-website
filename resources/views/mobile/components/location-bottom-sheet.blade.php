<!-- Location Bottom Sheet -->
<div id="locationBottomSheet" class="bottom-sheet rounded-top-5 shadow-premium">
    <div class="bottom-sheet-content">
        <div class="sheet-header p-4 pb-3 border-bottom border-light-subtle position-sticky top-0 bg-white" style="z-index: 10;">
            <div class="d-flex justify-content-center mb-3">
                <div class="bg-light rounded-pill" style="width: 40px; height: 5px;"></div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn-back d-none bg-light rounded-circle d-flex align-items-center justify-content-center border-0 p-0" style="width: 40px; height: 40px;">
                    <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-black"></i>
                </button>
                <div class="search-container flex-grow-1">
                    <div class="input-group-premium position-relative">
                        <i class="fa-solid fa-magnifying-glass icon" style="top: 50%; transform: translateY(-50%); position: absolute; {{ app()->getLocale() == 'ar' ? 'right: 15px;' : 'left: 15px;' }} color: #aaa;"></i>
                        <input type="text" class="form-control-premium border-light-subtle bg-light text-black fw-800" placeholder="{{ __('Search for a city or station') }}" id="locationSearch" style="padding-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 40px;">
                    </div>
                </div>
            </div>
        </div>

        <ul class="location-list main-list p-3 m-0">
            @foreach ($cities as $city)
                <li class="location-item bg-white rounded-5 border border-light-subtle mb-3 overflow-hidden shadow-sm" data-city="{{ $city->id }}">
                    <div class="city-header d-flex justify-content-between align-items-center p-3" style="cursor: pointer;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light text-main rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fa-solid fa-map-location-dot"></i>
                            </div>
                            <span class="fw-900 text-black fs-15">{{ $city->name }}</span>
                        </div>
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center toggle-arrow-container" style="width: 30px; height: 30px;">
                            <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} toggle-arrow text-muted fs-12"></i>
                        </div>
                    </div>
                    <ul class="sub-stations bg-light m-0 p-2" id="{{ $city->id }}-stations" style="display: none; border-top: 1px dashed #e0e0e0; list-style: none;">
                        @foreach ($city->stations as $station)
                            <li class="station-item rounded-4 mb-1" data-location="{{ $station->id }}" style="cursor: pointer;">
                                <div class="d-flex align-items-center p-3 gap-3">
                                    <i class="fa-solid fa-location-dot text-main fs-14"></i>
                                    <span class="fw-800 text-black fs-13">{{ $station->name }}</span>
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
                    const parent = this.closest('.location-item');
                    const subStations = parent.querySelector('.sub-stations');
                    const arrow = this.querySelector('.toggle-arrow');
                    const arrowContainer = this.querySelector('.toggle-arrow-container');

                    // Check if the sub-stations are currently visible
                    const isOpen = subStations.style.display === 'block';

                    // Toggle the display
                    if(isOpen) {
                        subStations.style.display = 'none';
                        parent.classList.remove('border-main-subtle', 'shadow-premium');
                        parent.style.borderColor = '';
                        arrowContainer.classList.remove('bg-main', 'text-white');
                        arrowContainer.classList.add('bg-light');
                        arrow.classList.remove('fa-chevron-down', 'text-white');
                        arrow.classList.add('fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}', 'text-muted');
                    } else {
                        // Close others first
                        document.querySelectorAll('.sub-stations').forEach(sub => {
                            if(sub !== subStations) {
                                sub.style.display = 'none';
                                const otherParent = sub.closest('.location-item');
                                otherParent.classList.remove('border-main-subtle', 'shadow-premium');
                                otherParent.style.borderColor = '';
                                const otherArrowCont = otherParent.querySelector('.toggle-arrow-container');
                                if(otherArrowCont) {
                                    otherArrowCont.classList.remove('bg-main', 'text-white');
                                    otherArrowCont.classList.add('bg-light');
                                    const otherArrow = otherArrowCont.querySelector('.toggle-arrow');
                                    if(otherArrow) {
                                        otherArrow.classList.remove('fa-chevron-down', 'text-white');
                                        otherArrow.classList.add('fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}', 'text-muted');
                                    }
                                }
                            }
                        });

                        subStations.style.display = 'block';
                        parent.classList.add('border-main-subtle', 'shadow-premium');
                        parent.style.borderColor = 'var(--main-color)';
                        arrowContainer.classList.remove('bg-light');
                        arrowContainer.classList.add('bg-main', 'text-white');
                        arrow.classList.remove('fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}', 'text-muted');
                        arrow.classList.add('fa-chevron-down', 'text-white');
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
            bottom: -100%;
            left: 0;
            right: 0;
            background: #f8f9fa; /* slightly off-white for contrast with white cards */
            z-index: 1050;
            max-height: 85vh;
            display: flex;
            flex-direction: column;
            transition: bottom 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            border-top-left-radius: 30px !important;
            border-top-right-radius: 30px !important;
        }

        .bottom-sheet.show {
            bottom: 0;
        }

        .bottom-sheet-content {
            overflow-y: auto;
            flex: 1;
            padding-bottom: 2rem;
        }

        .station-item {
            transition: all 0.2s ease;
        }

        .station-item:hover, .station-item:active {
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transform: translateX({{ app()->getLocale() == 'ar' ? '-5px' : '5px' }});
        }

        .toggle-arrow {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .toggle-arrow-container {
            transition: all 0.3s ease;
        }
        
        .location-item {
            transition: all 0.3s ease;
        }
        
        #locationSearch {
            height: 50px;
            border-radius: 14px;
        }
        
        #locationSearch:focus {
            background-color: #fff !important;
            box-shadow: 0 0 0 4px rgba(var(--main-color-rgb), 0.1);
            border-color: var(--main-color) !important;
        }

        .wheel-picker-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            backdrop-filter: blur(2px);
        }

        .wheel-picker-container {
            position: fixed;
            bottom: -100%;
            left: 0;
            right: 0;
            background: #fff;
            border-top-left-radius: 30px;
            border-top-right-radius: 30px;
            z-index: 1050;
            transition: bottom 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            box-shadow: 0 -5px 25px rgba(0,0,0,0.1);
        }

        .wheel-picker-container.active {
            bottom: 0;
        }

        .wheel-picker-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #eee;
        }

        .wheel-picker-content {
            display: flex;
            justify-content: space-between;
            height: 250px;
            position: relative;
            overflow: hidden;
            padding: 0 20px;
        }

        .wheel-selection-indicator {
            position: absolute;
            top: 50%;
            left: 20px;
            right: 20px;
            height: 40px;
            transform: translateY(-50%);
            border-top: 2px solid var(--main-color);
            border-bottom: 2px solid var(--main-color);
            background: rgba(var(--main-color-rgb), 0.05);
            border-radius: 8px;
            pointer-events: none;
        }

        .wheel-column {
            flex: 1;
            overflow-y: auto;
            scroll-snap-type: y mandatory;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding: 105px 0; /* (250 - 40) / 2 */
        }

        .wheel-column::-webkit-scrollbar {
            display: none;
        }

        .wheel-item {
            height: 40px;
            line-height: 40px;
            scroll-snap-align: center;
            font-size: 18px;
            font-weight: 800;
            color: #ccc;
            transition: all 0.2s;
        }

        .wheel-item.selected {
            color: var(--main-color);
            font-size: 22px;
            font-weight: 900;
        }
    </style>
@endpush
