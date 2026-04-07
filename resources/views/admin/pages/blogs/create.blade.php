@extends('admin.layouts.master')

@section('title', isset($item) ? __('Edit Blog') : __('Create Blog'))

@section('breadcrumb')
    <x-admin.page-header
        :title="isset($item) ? __('Edit Blog') : __('Create Blog')"
        :parent-url="route('admin.blogs.index')"
        :parent-label="__('Blogs')" />
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
                    <form id="blogAdminForm" method="POST" action="{{ isset($item) ? route('admin.blogs.update', $item) : route('admin.blogs.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if (isset($item))
                            @method('PUT')
                        @endif

                        <div class="row mb-3">
                            @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title_{{ $lang }}">{{ __('Title') }} ({{ $label }})</label>
                                        <input type="text" class="form-control" id="title_{{ $lang }}" name="title[{{ $lang }}]" value="{{ old("title.$lang", isset($item) ? ($item->title[$lang] ?? '') : '') }}" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <div class="form-group mb-3">
                            <label for="image">{{ __('Image') }}</label>
                            <input type="file" class="dropify" id="image" name="image" data-default-file="{{ isset($item) && $item->image ? asset($item->image) : '' }}">
                        </div>

                        <div class="row mb-3">
                            @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                                <div class="col-12 mb-4">
                                    <div class="form-group">
                                        <label for="content_{{ $lang }}" class="form-label fw-semibold">{{ __('Content') }} ({{ $label }})</label>
                                        <textarea
                                            class="form-control blog-rich-editor"
                                            id="content_{{ $lang }}"
                                            name="content[{{ $lang }}]"
                                            rows="14"
                                            data-editor-dir="{{ $lang === 'ar' ? 'rtl' : 'ltr' }}"
                                            data-editor-lang="{{ $lang === 'ar' ? 'ar' : 'en' }}"
                                            required>{{ old('content.'.$lang, isset($item) ? ($item->content[$lang] ?? '') : '') }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group mb-3">
                            <label for="category_id">{{ __('Category') }}</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">{{ __('Select Category') }}</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $item->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->translated_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="views">{{ __('Views') }}</label>
                                    <input type="number" class="form-control" id="views" name="views" value="{{ old('views', isset($item) ? $item->views : 0) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="likes">{{ __('Likes') }}</label>
                                    <input type="number" class="form-control" id="likes" name="likes" value="{{ old('likes', isset($item) ? $item->likes : 0) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="reading_time">{{ __('Reading Time (mins)') }}</label>
                                    <input type="number" class="form-control" id="reading_time" name="reading_time" value="{{ old('reading_time', isset($item) ? $item->reading_time : 0) }}">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meta_title_{{ $lang }}">{{ __('Meta Title') }} ({{ $label }})</label>
                                        <input type="text" class="form-control" id="meta_title_{{ $lang }}" name="meta_title[{{ $lang }}]" value="{{ old("meta_title.$lang", isset($item) ? ($item->meta_title[$lang] ?? '') : '') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description_{{ $lang }}">{{ __('Meta Description') }} ({{ $label }})</label>
                                        <textarea class="form-control" id="meta_description_{{ $lang }}" name="meta_description[{{ $lang }}]" rows="8">{{ old("meta_description.$lang", isset($item) ? ($item->meta_description[$lang] ?? '') : '') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_tags_{{ $lang }}">{{ __('Meta Tags') }} ({{ $label }})</label>
                                        <input type="text" class="form-control" id="meta_tags_{{ $lang }}" name="meta_tags[{{ $lang }}]" value="{{ old("meta_tags.$lang", isset($item) && is_array($item->meta_tags ?? null) ? implode(',', $item->meta_tags[$lang] ?? []) : '') }}">
                                        <small class="text-muted">{{ __('Comma separated') }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            {{ isset($item) ? __('Update') : __('Create') }}
                        </button>
                    </form>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.4/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.jQuery) {
                jQuery('.dropify').dropify();
            }

            if (typeof tinymce === 'undefined') {
                return;
            }

            var common = {
                height: 420,
                z_index: 12000,
                menubar: false,
                branding: false,
                promotion: false,
                relative_urls: false,
                convert_urls: false,
                plugins: 'lists link image table code autoresize fullscreen help wordcount directionality',
                toolbar: 'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image table | removeformat code fullscreen | ltr rtl help',
                block_formats: 'Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4',
                content_style: 'body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Cairo, sans-serif; font-size: 15px; }',
                setup: function(editor) {
                    editor.on('change keyup', function() {
                        editor.save();
                    });
                }
            };

            document.querySelectorAll('textarea.blog-rich-editor').forEach(function(el) {
                if (!el.id) {
                    return;
                }
                var dir = el.getAttribute('data-editor-dir') || 'ltr';
                var lang = el.getAttribute('data-editor-lang') || 'en';
                var cfg = Object.assign({}, common, {
                    selector: '#' + el.id,
                    directionality: dir,
                    language: lang === 'ar' ? 'ar' : 'en',
                });
                if (lang === 'ar') {
                    cfg.language_url = 'https://cdn.jsdelivr.net/npm/tinymce@6.8.4/langs/ar.js';
                }
                tinymce.init(cfg);
            });

            var blogForm = document.getElementById('blogAdminForm');
            if (blogForm) {
                blogForm.addEventListener('submit', function() {
                    if (typeof tinymce !== 'undefined') {
                        tinymce.triggerSave();
                    }
                });
            }
        });
    </script>
@endpush
