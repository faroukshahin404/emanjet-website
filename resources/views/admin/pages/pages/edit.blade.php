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
    </style>
@endpush


@section('content')
    <div class="edit-page-container">
        <div class="page-header">
            <h1 class="page-title">Edit Page: {{ $page->title }}</h1>
            <a href="{{ route('admin.pages.index') }}" class="back-button">Back</a>
        </div>

        @if ($errors->any())
            <div class="error-container">
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card">
            <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <!-- Basic Information -->
                    <div class="form-section">
                        <h2 class="section-title">Basic Information</h2>

                        <div class="form-group">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug) }}"
                                class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $page->title) }}"
                                class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title"
                                value="{{ old('meta_title', $page->meta_title) }}" class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="3" class="form-textarea">{{ old('meta_description', $page->meta_description) }}</textarea>
                        </div>
                    </div>

                    <!-- Meta Tags -->
                    <div class="form-section">
                        <h2 class="section-title">Meta Tags</h2>

                        <div class="form-group">
                            <label for="meta_tags_image" class="form-label">Image</label>
                            <input type="text" name="meta_tags[image]" id="meta_tags_image"
                                value="{{ old('meta_tags.image', $page->meta_tags['image'] ?? '') }}" class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="meta_tags_keywords" class="form-label">Keywords</label>
                            <input type="text" name="meta_tags[keywords]" id="meta_tags_keywords"
                                value="{{ old('meta_tags.keywords', $page->meta_tags['keywords'] ?? '') }}"
                                class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="meta_tags_og_image" class="form-label">OG Image</label>
                            <input type="text" name="meta_tags[og_image]" id="meta_tags_og_image"
                                value="{{ old('meta_tags.og_image', $page->meta_tags['og_image'] ?? '') }}"
                                class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="meta_tags_og_title" class="form-label">OG Title</label>
                            <input type="text" name="meta_tags[og_title]" id="meta_tags_og_title"
                                value="{{ old('meta_tags.og_title', $page->meta_tags['og_title'] ?? '') }}"
                                class="form-input">
                        </div>

                        <div class="form-group">
                            <label for="meta_tags_og_description" class="form-label">OG Description</label>
                            <textarea name="meta_tags[og_description]" id="meta_tags_og_description" rows="3" class="form-textarea">{{ old('meta_tags.og_description', $page->meta_tags['og_description'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-button">Update Page</button>
                </div>
            </form>
        </div>
    </div>
@endsection
