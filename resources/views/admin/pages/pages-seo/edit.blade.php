@extends('admin.layouts.master')

@push('css')
    <style>
        /* Custom Styling for SEO Section Edit Page */
        .seo-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem 1rem;
        }

        .seo-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .seo-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .seo-back-btn {
            background-color: #6c757d;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .seo-back-btn:hover {
            background-color: #5a6268;
        }

        .seo-errors {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 0.75rem 1rem;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
        }

        .seo-errors ul {
            list-style-type: disc;
            padding-left: 1.25rem;
        }

        .seo-form-container {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        .seo-section {
            margin-bottom: 1.5rem;
        }

        .seo-section-title {
            font-size: 1.25rem;
            font-weight: 600;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
            color: #2c3e50;
        }

        .seo-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .seo-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .seo-form-group {
            margin-bottom: 1rem;
        }

        .seo-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 0.25rem;
        }

        .seo-input,
        .seo-select,
        .seo-textarea {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #cbd5e0;
            border-radius: 0.25rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .seo-input:focus,
        .seo-select:focus,
        .seo-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }

        .seo-textarea {
            resize: vertical;
            min-height: 80px;
        }

        .seo-item-container {
            border: 1px solid #e2e8f0;
            border-radius: 0.25rem;
            padding: 0.75rem;
            background-color: #f8fafc;
            margin-bottom: 1rem;
        }

        .seo-item-title {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #4a5568;
        }

        .seo-complex-notice {
            background-color: #fff8e6;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 0.75rem;
            border-radius: 0.25rem;
        }

        .seo-submit-container {
            margin-top: 1.5rem;
            text-align: right;
        }

        .seo-submit-btn {
            background-color: #3b82f6;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 0.25rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .seo-submit-btn:hover {
            background-color: #2563eb;
        }

        /* Language tabs */
        .language-tabs {
            display: flex;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 1rem;
        }

        .language-tab {
            padding: 0.5rem 1rem;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .language-tab.active {
            border-bottom-color: #3b82f6;
            color: #3b82f6;
        }

        .language-content {
            display: none;
        }

        .language-content.active {
            display: block;
        }

        .rtl-text {
            direction: rtl;
            text-align: right;
        }

        .add-item-btn {
            background-color: #10b981;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            cursor: pointer;
            margin-top: 1rem;
        }

        .add-item-btn:hover {
            background-color: #059669;
        }

        .remove-item-btn {
            background-color: #ef4444;
            color: white;
            border: none;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            cursor: pointer;
            font-size: 0.75rem;
            margin-left: 0.5rem;
        }

        .remove-item-btn:hover {
            background-color: #dc2626;
        }
    </style>
@endpush

@section('content')
    <div class="seo-container">
        <div class="seo-header">
            <h1 class="seo-title">Edit SEO Section: {{ ucfirst(str_replace('-', ' ', $pageSeo->section_type)) }}</h1>
            <a href="{{ route('admin.pages-seo.index', $pageSeo->page_id) }}" class="seo-back-btn">Back</a>
        </div>
        <div class="seo-form-container">
            <form action="{{ route('admin.pages-seo.update', $pageSeo->id) }}" method="POST" enctype="multipart/form-data"> 
                @csrf
                @method('PUT')

                <div class="seo-section">
                    <h2 class="seo-section-title">Section Settings</h2>

                    <div class="seo-grid">
                        <div class="seo-form-group">
                            <label for="section_type" class="seo-label">Section Type</label>
                            <input type="text" name="section_type" id="section_type"
                                value="{{ old('section_type', $pageSeo->section_type) }}" class="seo-input">
                        </div>

                        <div class="seo-form-group">
                            <label for="order" class="seo-label">Display Order</label>
                            <input type="number" name="order" id="order" value="{{ old('order', $pageSeo->order) }}"
                                class="seo-input">
                        </div>

                        <div class="seo-form-group">
                            <label for="status" class="seo-label">Status</label>
                            <select name="status" id="status" class="seo-select">
                                <option value="1" {{ old('status', $pageSeo->status) == 1 ? 'selected' : '' }}>Active
                                </option>
                                <option value="0" {{ old('status', $pageSeo->status) == 0 ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="seo-section">
                    <h2 class="seo-section-title">Content</h2>

                    @php
                        $contentArray = is_array($pageSeo->content_json)
                            ? $pageSeo->content_json
                            : json_decode($pageSeo->content_json, true);
                    @endphp

                    <div class="language-tabs">
                        <div class="language-tab active" data-lang="en">English</div>
                        <div class="language-tab" data-lang="ar">Arabic</div>
                    </div>

                    <!-- English Content -->
                    <div id="language-content-en" class="language-content active">
                        @if (isset($contentArray['en']))
                            @foreach ($contentArray['en'] as $key => $value)
                                <div class="seo-form-group">
                                    <label for="content_en_{{ $key }}" class="seo-label">
                                        {{ ucfirst(str_replace(['_', '-'], ' ', $key)) }}
                                    </label>

                                    @if ($key === 'image')
                                        <!-- Single image upload field -->
                                        <div class="image-upload-container">
                                            @if (is_string($value) && !empty($value))
                                                <div class="current-image">
                                                    <img src="{{ asset($value) }}" alt="Current Image" class="img-thumbnail"
                                                        style="max-height: 100px;">
                                                    <input type="hidden" name="content_json[en][{{ $key }}]"
                                                        value="{{ $value }}">
                                                </div>
                                            @endif
                                            <input type="file" name="image_uploads[en][{{ $key }}]"
                                                class="seo-input" accept="image/*">
                                        </div>
                                    @elseif ($key === 'images')
                                        <!-- Multiple images upload field -->
                                        <div class="multi-image-container" id="en_images_container">
                                            @if (is_array($value))
                                                @foreach ($value as $index => $imagePath)
                                                    <div class="image-item">
                                                        <img src="{{ asset($imagePath) }}" alt="Image {{ $index }}"
                                                            class="img-thumbnail" style="max-height: 100px;">
                                                        <input type="hidden" name="content_json[en][images][]"
                                                            value="{{ $imagePath }}">
                                                        <button type="button" class="remove-image-btn">Remove</button>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <input type="file" name="image_uploads[en][images][]" class="seo-input"
                                                accept="image/*" multiple>
                                        </div>
                                        <button type="button" class="add-image-btn" data-container="en_images_container">
                                            Add More Images
                                        </button>
                                    @elseif (is_array($value))
                                        @if (isset($value[0]) && is_string($value[0]))
                                            <div id="en_{{ $key }}_items">
                                                @foreach ($value as $index => $item)
                                                    <div class="seo-item-container">
                                                        <div class="d-flex justify-content-between">
                                                            <input type="text"
                                                                name="content_json[en][{{ $key }}][]"
                                                                value="{{ $item }}" class="seo-input">
                                                            <button type="button" class="remove-item-btn">Remove</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="add-item-btn"
                                                data-container="en_{{ $key }}_items" data-type="string">
                                                Add Item
                                            </button>
                                        @endif
                                    @else
                                        @if (is_string($value) && strlen($value) > 100)
                                            <textarea name="content_json[en][{{ $key }}]" class="seo-textarea">{{ $value }}</textarea>
                                        @else
                                            <input type="text" name="content_json[en][{{ $key }}]"
                                                value="{{ $value }}" class="seo-input">
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Arabic Content -->
                    <div id="language-content-ar" class="language-content">
                        @if (isset($contentArray['ar']))
                            @foreach ($contentArray['ar'] as $key => $value)
                                <div class="seo-form-group">
                                    <label for="content_ar_{{ $key }}" class="seo-label">
                                        {{ ucfirst(str_replace(['_', '-'], ' ', $key)) }}
                                    </label>

                                    @if ($key === 'image')
                                        <!-- Single image upload field -->
                                        <div class="image-upload-container">
                                            @if (is_string($value) && !empty($value))
                                                <div class="current-image">
                                                    <img src="{{ asset($value) }}" alt="Current Image"
                                                        class="img-thumbnail" style="max-height: 100px;">
                                                    <input type="hidden" name="content_json[ar][{{ $key }}]"
                                                        value="{{ $value }}">
                                                </div>
                                            @endif
                                            <input type="file" name="image_uploads[ar][{{ $key }}]"
                                                class="seo-input" accept="image/*">
                                        </div>
                                    @elseif ($key === 'images')
                                        <!-- Multiple images upload field -->
                                        <div class="multi-image-container" id="ar_images_container">
                                            @if (is_array($value))
                                                @foreach ($value as $index => $imagePath)
                                                    <div class="image-item">
                                                        <img src="{{ asset($imagePath) }}"
                                                            alt="Image {{ $index }}" class="img-thumbnail"
                                                            style="max-height: 100px;">
                                                        <input type="hidden" name="content_json[ar][images][]"
                                                            value="{{ $imagePath }}">
                                                        <button type="button" class="remove-image-btn">Remove</button>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <input type="file" name="image_uploads[ar][images][]" class="seo-input"
                                                accept="image/*" multiple>
                                        </div>
                                        <button type="button" class="add-image-btn"
                                            data-container="ar_images_container">
                                            Add More Images
                                        </button>
                                    @elseif (is_array($value))
                                        @if (isset($value[0]) && is_string($value[0]))
                                            <div id="ar_{{ $key }}_items">
                                                @foreach ($value as $index => $item)
                                                    <div class="seo-item-container">
                                                        <div class="d-flex justify-content-between">
                                                            <input type="text"
                                                                name="content_json[ar][{{ $key }}][]"
                                                                value="{{ $item }}" class="seo-input rtl-text">
                                                            <button type="button" class="remove-item-btn">Remove</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="add-item-btn"
                                                data-container="ar_{{ $key }}_items" data-type="string">
                                                Add Item
                                            </button>
                                        @endif
                                    @else
                                        @if (is_string($value) && strlen($value) > 100)
                                            <textarea name="content_json[ar][{{ $key }}]" class="seo-textarea rtl-text">{{ $value }}</textarea>
                                        @else
                                            <input type="text" name="content_json[ar][{{ $key }}]"
                                                value="{{ $value }}" class="seo-input rtl-text">
                                        @endif
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="seo-submit-container">
                    <button type="submit" class="seo-submit-btn">
                        Update SEO Section
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.language-tab');
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const lang = tab.getAttribute('data-lang');

                    // Update active tab
                    document.querySelectorAll('.language-tab').forEach(t => t.classList.remove(
                        'active'));
                    tab.classList.add('active');

                    // Update active content
                    document.querySelectorAll('.language-content').forEach(content => content
                        .classList.remove('active'));
                    document.getElementById(`language-content-${lang}`).classList.add('active');
                });
            });

            document.querySelectorAll('.add-item-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const containerId = this.getAttribute('data-container');
                    const container = document.getElementById(containerId);
                    const type = this.getAttribute('data-type');

                    if (type === 'string') {
                        const parts = containerId.split('_');
                        const lang = parts[0];
                        const key = parts[1];

                        // Add new string item
                        const div = document.createElement('div');
                        div.className = 'seo-item-container';
                        div.innerHTML = `
                    <div class="d-flex justify-content-between">
                        <input type="text" name="content_json[${lang}][${key}][]" 
                               class="seo-input${lang === 'ar' ? ' rtl-text' : ''}">
                        <button type="button" class="remove-item-btn">Remove</button>
                    </div>
                `;
                        container.appendChild(div);

                        div.querySelector('.remove-item-btn').addEventListener('click', function() {
                            div.remove();
                        });
                    }
                });
            });

            // Add image functionality
            document.querySelectorAll('.add-image-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const containerId = this.getAttribute('data-container');
                    const container = document.getElementById(containerId);

                    const fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = `image_uploads[${containerId.split('_')[0]}][images][]`;
                    fileInput.className = 'seo-input';
                    fileInput.accept = 'image/*';
                    fileInput.style.marginTop = '10px';

                    container.appendChild(fileInput);
                });
            });

            document.querySelectorAll('.remove-item-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.seo-item-container, .image-item').remove();
                });
            });

            document.querySelectorAll('.remove-image-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.image-item').remove();
                });
            });
        });
    </script>
@endpush
