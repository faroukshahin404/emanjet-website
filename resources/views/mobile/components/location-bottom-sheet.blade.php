<!-- Location Bottom Sheet -->
<div id="locationBottomSheet" class="bottom-sheet">
    <div class="bottom-sheet-content">
        <div class="sheet-header p-3 d-flex align-items-center">
            <button type="button" class="btn-back d-none">
                <i class="fas fa-arrow-right"></i>
            </button>
            <div class="search-container flex-grow-1">
                <input type="text" class="form-control" placeholder="بحث" id="locationSearch">
            </div>
        </div>

        <ul class="location-list main-list">
            @foreach ($cities as $city)
                <li class="location-item" data-city="{{$city->id}}">
                    <div class="city-header d-flex justify-content-between align-items-center p-3">
                        <span>{{$city->name}}</span>
                        <i class="fas fa-chevron-left"></i>
                    </div>
                    <ul class="sub-stations" id="{{$city->id}}-stations">
                        @foreach ($city->stations as $station)
                            <li class="station-item" data-location="{{$station->id}}">
                                <div class="d-flex align-items-center p-3">
                                    <span>{{$station->name}}</span>
                                </div>
                            </li>
                        @endforeach
                      
                    </ul>
                </li>
            @endforeach


        </ul>
    </div>
</div>
