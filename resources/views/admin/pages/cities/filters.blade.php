<form method="GET" action="{{ route('admin.cities.index') }}">
    <div class="box">
        <div class="box-body">
            <div class="row align-items-end"> <!-- تغيير من align-items-center إلى align-items-end -->
                <div class="col-md-4">
                    <label for="city">{{ __('Cities') }}</label>
                    <select id="city" name="city" class="form-control select2">
                        <option value="">{{ __('Select city') }}</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ request('city') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
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
                    <a href="{{ route('admin.cities.index') }}" class="btn btn-default ml-2">
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
        // تأكد من تفعيل select2 بعد تحميل الصفحة بالكامل
        if($.fn.select2) {
            $('.select2').select2({
                placeholder: "{{ __('Select City') }}",
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
</style>
@endsection
