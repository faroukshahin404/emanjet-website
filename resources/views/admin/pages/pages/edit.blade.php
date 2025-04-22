@extends('admin.layouts.master')

@push('css')
    <style>
        /* Main Container */
        .edit-page-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem 1rem;
        }

        /* Header Section */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
        }

        .back-button {
            background-color: #64748b;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #475569;
        }

        /* Error Messages */
        .error-container {
            background-color: #fee2e2;
            border: 1px solid #f87171;
            color: #b91c1c;
            padding: 0.75rem 1rem;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
        }

        .error-list {
            list-style-type: disc;
            padding-left: 1.25rem;
        }

        /* Main Form Card */
        .form-card {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
        }

        /* Form Grid Layout */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        /* Section Containers */
        .form-section {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e5e7eb;
            color: #1f2937;
        }

        /* Form Fields */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #4b5563;
            margin-bottom: 0.25rem;
        }

        .form-input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }

        .form-textarea {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            min-height: 5rem;
            resize: vertical;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }

        /* Language Tabs */
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

        /* Submit Button Container */
        .form-actions {
            margin-top: 1.5rem;
            text-align: right;
        }

        .submit-button {
            background-color: #3b82f6;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-button:hover {
            background-color: #2563eb;
        }

        /* Status Field */
        .status-field {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .status-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #4b5563;
        }

        .status-checkbox {
            width: 1rem;
            height: 1rem;
        }

        /* Image Preview */
        .image-preview {
            margin-top: 0.5rem;
        }

        .image-preview img {
            max-width: 100px;
            max-height: 100px;
            border: 1px solid #e5e7eb;
            border-radius: 0.25rem;
            padding: 0.25rem;
        }

        .current-file-name {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }
    </style>
@endpush

@section('content')
    <div class="edit-page-container">
        <div class="form-card">
            @if ($errors->any())
                <div class="error-container">
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug) }}"
                        class="form-input">
                </div>

                <div class="form-grid">
                    <!-- English Language Content -->
                    <div class="form-section">
                        <div class="language-tabs">
                            <div class="language-tab active" data-lang="en">English</div>
                            <div class="language-tab" data-lang="ar">Arabic</div>
                        </div>

                        <div id="en-content" class="language-content active">
                            <h2 class="section-title">Basic Information</h2>

                            <div class="form-group">
                                <label for="title_en" class="form-label">Title</label>
                                <input type="text" name="title[en]" id="title_en"
                                    value="{{ old('title.en', is_array($page->title) ? $page->title['en'] : $page->title) }}"
                                    class="form-input">
                            </div>

                            <div class="form-group">
                                <label for="meta_title_en" class="form-label">Meta Title</label>
                                <input type="text" name="meta_title[en]" id="meta_title_en"
                                    value="{{ old('meta_title.en', is_array($page->meta_title) ? $page->meta_title['en'] : $page->meta_title) }}"
                                    class="form-input">
                            </div>

                            <div class="form-group">
                                <label for="meta_description_en" class="form-label">Meta Description</label>
                                <textarea name="meta_description[en]" id="meta_description_en" rows="3" class="form-textarea">{{ old('meta_description.en', is_array($page->meta_description) ? $page->meta_description['en'] : $page->meta_description) }}</textarea>
                            </div>

                            <h2 class="section-title">Meta Tags</h2>

                            <div class="form-group">
                                <label for="meta_tags_image_en" class="form-label">Image</label>
                                <input type="file" name="meta_tags_image_en" id="meta_tags_image_en" class="form-input">
                                @if(isset($page->meta_tags['en']) && $page->meta_tags['en']['image'])
                                    <div class="image-preview">
                                        <img src="{{ asset($page->meta_tags['en']['image']) }}" alt="Current image">
                                        <p class="current-file-name">Current: {{ basename($page->meta_tags['en']['image']) }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="meta_tags_keywords_en" class="form-label">Keywords</label>
                                <input type="text" name="meta_tags[en][keywords]" id="meta_tags_keywords_en"
                                    value="{{ old('meta_tags.en.keywords', isset($page->meta_tags['en']) ? $page->meta_tags['en']['keywords'] : '') }}"
                                    class="form-input">
                            </div>

                            <div class="form-group">
                                <label for="meta_tags_og_image_en" class="form-label">OG Image</label>
                                <input type="file" name="meta_tags_og_image_en" id="meta_tags_og_image_en" class="form-input">
                                @if(isset($page->meta_tags['en']) && $page->meta_tags['en']['og_image'])
                                    <div class="image-preview">
                                        <img src="{{ asset($page->meta_tags['en']['og_image']) }}" alt="Current OG image">
                                        <p class="current-file-name">Current: {{ basename($page->meta_tags['en']['og_image']) }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="meta_tags_og_title_en" class="form-label">OG Title</label>
                                <input type="text" name="meta_tags[en][og_title]" id="meta_tags_og_title_en"
                                    value="{{ old('meta_tags.en.og_title', isset($page->meta_tags['en']) ? $page->meta_tags['en']['og_title'] : '') }}"
                                    class="form-input">
                            </div>

                            <div class="form-group">
                                <label for="meta_tags_og_description_en" class="form-label">OG Description</label>
                                <textarea name="meta_tags[en][og_description]" id="meta_tags_og_description_en" rows="3" class="form-textarea">{{ old('meta_tags.en.og_description', isset($page->meta_tags['en']) ? $page->meta_tags['en']['og_description'] : '') }}</textarea>
                            </div>
                        </div>

                        <!-- Arabic Language Content -->
                        <div id="ar-content" class="language-content">
                            <h2 class="section-title">Basic Information</h2>

                            <div class="form-group">
                                <label for="title_ar" class="form-label">Title</label>
                                <input type="text" name="title[ar]" id="title_ar"
                                    value="{{ old('title.ar', is_array($page->title) ? $page->title['ar'] : '') }}"
                                    class="form-input" dir="rtl">
                            </div>

                            <div class="form-group">
                                <label for="meta_title_ar" class="form-label">Meta Title</label>
                                <input type="text" name="meta_title[ar]" id="meta_title_ar"
                                    value="{{ old('meta_title.ar', is_array($page->meta_title) ? $page->meta_title['ar'] : '') }}"
                                    class="form-input" dir="rtl">
                            </div>

                            <div class="form-group">
                                <label for="meta_description_ar" class="form-label">Meta Description</label>
                                <textarea name="meta_description[ar]" id="meta_description_ar" rows="3" class="form-textarea" dir="rtl">{{ old('meta_description.ar', is_array($page->meta_description) ? $page->meta_description['ar'] : '') }}</textarea>
                            </div>

                            <h2 class="section-title">Meta Tags</h2>

                            <div class="form-group">
                                <label for="meta_tags_image_ar" class="form-label">Image</label>
                                <input type="file" name="meta_tags_image_ar" id="meta_tags_image_ar" class="form-input">
                                @if(isset($page->meta_tags['ar']) && $page->meta_tags['ar']['image'])
                                    <div class="image-preview">
                                        <img src="{{ asset($page->meta_tags['ar']['image']) }}" alt="Current image">
                                        <p class="current-file-name">Current: {{ basename($page->meta_tags['ar']['image']) }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="meta_tags_keywords_ar" class="form-label">Keywords</label>
                                <input type="text" name="meta_tags[ar][keywords]" id="meta_tags_keywords_ar"
                                    value="{{ old('meta_tags.ar.keywords', isset($page->meta_tags['ar']) ? $page->meta_tags['ar']['keywords'] : '') }}"
                                    class="form-input" dir="rtl">
                            </div>

                            <div class="form-group">
                                <label for="meta_tags_og_image_ar" class="form-label">OG Image</label>
                                <input type="file" name="meta_tags_og_image_ar" id="meta_tags_og_image_ar" class="form-input">
                                @if(isset($page->meta_tags['ar']) && $page->meta_tags['ar']['og_image'])
                                    <div class="image-preview">
                                        <img src="{{ asset($page->meta_tags['ar']['og_image']) }}" alt="Current OG image">
                                        <p class="current-file-name">Current: {{ basename($page->meta_tags['ar']['og_image']) }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="meta_tags_og_title_ar" class="form-label">OG Title</label>
                                <input type="text" name="meta_tags[ar][og_title]" id="meta_tags_og_title_ar"
                                    value="{{ old('meta_tags.ar.og_title', isset($page->meta_tags['ar']) ? $page->meta_tags['ar']['og_title'] : '') }}"
                                    class="form-input" dir="rtl">
                            </div>

                            <div class="form-group">
                                <label for="meta_tags_og_description_ar" class="form-label">OG Description</label>
                                <textarea name="meta_tags[ar][og_description]" id="meta_tags_og_description_ar" rows="3" class="form-textarea"
                                    dir="rtl">{{ old('meta_tags.ar.og_description', isset($page->meta_tags['ar']) ? $page->meta_tags['ar']['og_description'] : '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Page Settings -->
                    <div class="form-section">
                        <h2 class="section-title">Page Settings</h2>

                        <div class="status-field">
                            <input type="checkbox" name="status" id="status" value="1" class="status-checkbox"
                                {{ $page->status ? 'checked' : '' }}>
                            <label for="status" class="status-label">Active</label>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="submit-button">Update Page</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.language-tab');
            const contents = document.querySelectorAll('.language-content');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const lang = tab.getAttribute('data-lang');

                    // Update active tab
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    // Update active content
                    contents.forEach(content => content.classList.remove('active'));
                    document.getElementById(`${lang}-content`).classList.add('active');
                });
            });

            // File input preview
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const fileName = this.value.split('\\').pop();
                    if (fileName) {
                        // Find closest preview element if it exists
                        const previewContainer = this.nextElementSibling;
                        if (previewContainer && previewContainer.classList.contains('image-preview')) {
                            const fileNameElement = previewContainer.querySelector('.current-file-name');
                            if (fileNameElement) {
                                fileNameElement.textContent = 'Selected: ' + fileName;
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection