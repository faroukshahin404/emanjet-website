<form method="GET" action="{{ route('admin.stations.index') }}">
    <div class="box">
        <div class="box-body">
            <div class="row align-items-end"> <!-- تغيير من align-items-center إلى align-items-end -->
                <div class="col-md-4">
                    <label for="station">{{ __('Station') }}</label>
                    <select id="station" name="station" class="form-control select2">
                        <option value="">{{ __('Select Station') }}</option>
                        @foreach($stations as $station)
                            <option value="{{ $station->id }}" {{ request('station') == $station->id ? 'selected' : '' }}>
                                {{ $station->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="status">{{ __('Status') }}</label>
                    <select id="status" name="status" class="form-control select2">
                        <option value="">{{ __('Select Status') }}</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>{{ __('Available') }}</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>{{ __('Unavailable') }}</option>
                    </select>
                </div>

                <div class="col-md-4 d-flex">
                    <!-- إزالة align-items-end من هنا -->
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-search"></i> {{ __('Search') }}
                    </button>
                    <a href="{{ route('admin.stations.index') }}" class="btn btn-default ml-2">
                        <i class="fa fa-undo"></i> {{ __('Reset') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(function() {
        if($.fn.select2) {
            $('.select2').select2({
                placeholder: function() {
                    return $(this).data('placeholder') || "{{ __('Select Option') }}";
                },
                allowClear: true,
                width: '100%'
            });
        } else {
            console.error('Select2 library is not loaded properly');
        }
    });
</script>
@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container {
        width: 100% !important;
    }
    .btn-default {
        background-color: #f4f4f4;
        border-color: #ddd;
        color: #444;
    }
    .ml-2 {
        margin-left: 0.5rem;
    }
</style>
@endsection
