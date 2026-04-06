@extends('admin.layouts.master')

@section('title', __('Edit SEO Section'))

@section('breadcrumb')
    <x-admin.page-header
        :title="__('Edit SEO Section') . ': ' . ucfirst(str_replace('-', ' ', $pageSeo->section_type))"
        :parent-url="route('admin.pages-seo.index', $pageSeo->page_id)"
        :parent-label="__('SEO Sections')" />
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

            <form action="{{ route('admin.pages-seo.update', $pageSeo->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

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

                @if (count($contentKeys) === 0)
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

                <button type="submit" class="btn btn-primary">{{ __('Update SEO Section') }}</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-item-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const containerId = this.getAttribute('data-container');
                    const container = document.getElementById(containerId);
                    const type = this.getAttribute('data-type');
                    if (!container || type !== 'string') return;

                    const parts = containerId.split('_');
                    const lang = parts[0];
                    const key = parts.slice(1, -1).join('_');

                    const div = document.createElement('div');
                    div.className = 'seo-item-container border rounded p-2 mb-2 bg-light';
                    div.innerHTML = `
                        <div class="d-flex justify-content-between gap-2 align-items-center">
                            <input type="text" name="content_json[${lang}][${key}][]"
                                class="form-control${lang === 'ar' ? ' text-end' : ''}"
                                ${lang === 'ar' ? 'dir="rtl"' : ''}>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-item-btn flex-shrink-0">{{ __('Remove') }}</button>
                        </div>
                    `;
                    container.appendChild(div);
                    div.querySelector('.remove-item-btn').addEventListener('click', function() {
                        div.remove();
                    });
                });
            });

            document.querySelectorAll('.add-image-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const containerId = this.getAttribute('data-container');
                    const container = document.getElementById(containerId);
                    if (!container) return;

                    const lang = containerId.split('_')[0];
                    const fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = `image_uploads[${lang}][images][]`;
                    fileInput.className = 'form-control mt-2';
                    fileInput.accept = 'image/*';
                    container.appendChild(fileInput);
                });
            });

            document.querySelectorAll('.remove-item-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const root = this.closest('.seo-item-container, .image-item');
                    if (root) root.remove();
                });
            });

            document.querySelectorAll('.remove-image-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const root = this.closest('.image-item');
                    if (root) root.remove();
                });
            });
        });
    </script>
@endsection
