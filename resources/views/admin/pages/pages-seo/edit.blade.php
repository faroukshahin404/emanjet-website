@extends('admin.layouts.master')

@section('title', __('Edit page section'))

@section('breadcrumb')
    <x-admin.page-header
        :title="__('Edit page section') . ': ' . ucfirst(str_replace('-', ' ', $pageSeo->section_type))"
        :parent-url="route('admin.pages.sections.index', ['page' => $pageSeo->page_id])"
        :parent-label="__('Page sections')" />
@endsection

@section('content')
    @php
        $contentArray = is_array($pageSeo->content_json)
            ? $pageSeo->content_json
            : json_decode($pageSeo->content_json, true);
        $contentArray = is_array($contentArray) ? $contentArray : [];
        $enContent = $contentArray['en'] ?? [];
        $arContent = $contentArray['ar'] ?? [];
        $contentKeys = array_values(array_unique(array_merge(array_keys($enContent), array_keys($arContent))));
    @endphp

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.page-sections.update', $pageSeo) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if ($pageSeo->section_type === 'hero-section')
                    <div class="alert alert-light border shadow-sm mb-4" role="note">
                        <div class="d-flex gap-2 align-items-start">
                            <i class="bi bi-image flex-shrink-0 fs-5 text-primary" aria-hidden="true"></i>
                            <div>
                                <strong class="d-block mb-1">{{ __('Page hero / banner') }}</strong>
                                <p class="small text-muted mb-0">
                                    {{ __('This section controls what visitors see at the top of the page (title, description, and the large image). Meta / OG images on the Page edit screen are separate and used for SEO & social previews.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <h5 class="fw-semibold mb-3 pb-2 border-bottom">{{ __('Section Settings') }}</h5>

                <div class="row mb-4">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label" for="section_type">{{ __('Section Type') }}</label>
                        <input type="text" name="section_type" id="section_type" value="{{ old('section_type', $pageSeo->section_type) }}" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label" for="order">{{ __('Display Order') }}</label>
                        <input type="number" name="order" id="order" value="{{ old('order', $pageSeo->order) }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="status">{{ __('Status') }}</label>
                        <select name="status" id="status" class="form-select">
                            <option value="1" {{ old('status', $pageSeo->status) == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="0" {{ old('status', $pageSeo->status) == 0 ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                        </select>
                    </div>
                </div>

                <h5 class="fw-semibold mb-3 pb-2 border-bottom">{{ __('Content') }}</h5>

                @if ($pageSeo->section_type === 'contact-us')
                    @php
                        $generalPageForContact = \App\Models\Page::where('slug', 'general')->first();
                        $socialSectionForContact = $generalPageForContact?->pageSeos
                            ?->firstWhere('section_type', 'social-media');
                    @endphp
                    <div class="alert alert-warning border-0 shadow-sm mb-4" role="note">
                        <i class="bi bi-info-circle me-2" aria-hidden="true"></i>
                        {{ __('Phone, WhatsApp, email and complaints email are now edited under the Social media section on the General page.') }}
                        @if ($socialSectionForContact)
                            <a href="{{ route('admin.page-sections.edit', $socialSectionForContact) }}"
                                class="alert-link fw-semibold ms-1">{{ __('Open Social media') }}</a>
                        @endif
                    </div>
                @elseif ($pageSeo->section_type === 'social-media')
                    @include('admin.pages.pages-seo.partials.social-links-editor', [
                        'enContent' => $enContent,
                        'arContent' => $arContent,
                    ])
                @elseif (count($contentKeys) === 0)
                    <p class="text-muted">{{ __('No translatable fields for this section.') }}</p>
                @else
                    @foreach ($contentKeys as $key)
                        <div class="row mb-4 align-items-start">
                            <div class="col-md-6">
                                @include('admin.pages.pages-seo.partials.content-field', [
                                    'lang' => 'en',
                                    'key' => $key,
                                    'value' => array_key_exists($key, $enContent) ? $enContent[$key] : null,
                                ])
                            </div>
                            <div class="col-md-6">
                                @include('admin.pages.pages-seo.partials.content-field', [
                                    'lang' => 'ar',
                                    'key' => $key,
                                    'value' => array_key_exists($key, $arContent) ? $arContent[$key] : null,
                                ])
                            </div>
                        </div>
                    @endforeach
                @endif

                <button type="submit" class="btn btn-primary">{{ __('Update section') }}</button>
            </form>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.jQuery && jQuery.fn.dropify) {
                jQuery('input.dropify').dropify({
                    messages: {
                        default: @json(__('Drag and drop a file here or click')),
                        replace: @json(__('Drag and drop or click to replace')),
                        remove: @json(__('Remove')),
                        error: @json(__('Something went wrong.'))
                    }
                });
            }

            document.querySelectorAll('.add-item-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var containerId = this.getAttribute('data-container');
                    var container = document.getElementById(containerId);
                    var type = this.getAttribute('data-type');
                    if (!container || type !== 'string') return;

                    var parts = containerId.split('_');
                    var lang = parts[0];
                    var key = parts.slice(1, -1).join('_');

                    var div = document.createElement('div');
                    div.className = 'seo-item-container border rounded p-2 mb-2 bg-light';
                    div.innerHTML =
                        '<div class="d-flex justify-content-between gap-2 align-items-center">' +
                        '<input type="text" name="content_json[' + lang + '][' + key + '][]" class="form-control' + (lang === 'ar' ? ' text-end' : '') + '" ' + (lang === 'ar' ? 'dir="rtl"' : '') + '>' +
                        '<button type="button" class="btn btn-sm btn-outline-danger remove-item-btn flex-shrink-0">{{ __('Remove') }}</button>' +
                        '</div>';
                    container.appendChild(div);
                    div.querySelector('.remove-item-btn').addEventListener('click', function() {
                        div.remove();
                    });
                });
            });

            document.querySelectorAll('.add-image-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var containerId = this.getAttribute('data-container');
                    var container = document.getElementById(containerId);
                    if (!container) return;

                    var lang = containerId.split('_')[0];
                    var fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = 'image_uploads[' + lang + '][images][]';
                    fileInput.className = 'form-control mt-2';
                    fileInput.accept = 'image/*';
                    container.appendChild(fileInput);
                });
            });

            document.querySelectorAll('.remove-item-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var root = this.closest('.seo-item-container, .image-item');
                    if (root) root.remove();
                });
            });

            document.querySelectorAll('.remove-image-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var root = this.closest('.image-item');
                    if (root) root.remove();
                });
            });
        });
    </script>
@endpush
