<form method="GET" action="{{ route('admin.blogs.index') }}">
    <div class="box">
        <div class="box-body">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label for="Blog">{{ __('Blog ') }}</label>
                    <select id="blog" name="blog" class="form-control select2">
                        <option value="">{{ __('Select Blog') }}</option>
                        @foreach($blogs as $blog)
                            <option value="{{ $blog->id }}" {{ request('blog') == $blog->id ? 'selected' : '' }}>
                                {{ $blog->translated_title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="category">{{ __('Category') }}</label>
                    <select id="category" name="category" class="form-control select2">
                        <option value="">{{ __('Select category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->translated_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex">
                    <!-- إزالة align-items-end من هنا -->
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-search"></i> {{ __('Search') }}
                    </button>
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-default mx-2">
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
