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
</style>
@endpush

@section('content')
<div class="seo-container">
    <div class="seo-header">
        <h1 class="seo-title">Edit SEO Section: {{ ucfirst(str_replace('-', ' ', $pageSeo->section_type)) }}</h1>
        <a href="{{ route('admin.pages-seo.index', $pageSeo->page_id) }}" class="seo-back-btn">Back</a>
    </div>

    @if($errors->any())
        <div class="seo-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="seo-form-container">
        <form action="{{ route('admin.pages-seo.update', $pageSeo->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="seo-section">
                <h2 class="seo-section-title">Section Settings</h2>
                
                <div class="seo-grid">
                    <div class="seo-form-group">
                        <label for="section_type" class="seo-label">Section Type</label>
                        <input type="text" name="section_type" id="section_type" value="{{ old('section_type', $pageSeo->section_type) }}" 
                            class="seo-input">
                    </div>
                    
                    <div class="seo-form-group">
                        <label for="order" class="seo-label">Display Order</label>
                        <input type="number" name="order" id="order" value="{{ old('order', $pageSeo->order) }}" 
                            class="seo-input">
                    </div>
                    
                    <div class="seo-form-group">
                        <label for="status" class="seo-label">Status</label>
                        <select name="status" id="status" class="seo-select">
                            <option value="1" {{ old('status', $pageSeo->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $pageSeo->status) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="seo-section">
                <h2 class="seo-section-title">Section Content</h2>
                
                @php
                    $contentArray = json_decode($pageSeo->content_json, true);
                @endphp
                
                @foreach($contentArray as $key => $value)
                    <div class="seo-form-group">
                        <label for="content_{{ $key }}" class="seo-label">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                        
                        @if(is_array($value))
                            @if(isset($value[0]) && is_string($value[0]))
                                <div class="seo-form-group">
                                    @foreach($value as $index => $item)
                                        <input type="text" name="{{ $key }}[{{ $index }}]" id="content_{{ $key }}_{{ $index }}" 
                                            value="{{ old($key.'.'.$index, $item) }}" 
                                            class="seo-input" style="margin-bottom: 0.5rem;">
                                    @endforeach
                                </div>
                            @elseif(isset($value[0]) && is_array($value[0]))
                                <div class="seo-form-group">
                                    @foreach($value as $index => $object)
                                        <div class="seo-item-container">
                                            <h4 class="seo-item-title">Item {{ $index + 1 }}</h4>
                                            <div class="seo-form-group">
                                                @foreach($object as $objKey => $objValue)
                                                    <div class="seo-form-group">
                                                        <label for="content_{{ $key }}_{{ $index }}_{{ $objKey }}" class="seo-label">
                                                            {{ ucfirst(str_replace('_', ' ', $objKey)) }}
                                                        </label>
                                                        @if(is_string($objValue) && strlen($objValue) > 100)
                                                            <textarea name="{{ $key }}[{{ $index }}][{{ $objKey }}]" 
                                                                id="content_{{ $key }}_{{ $index }}_{{ $objKey }}" rows="3"
                                                                class="seo-textarea">{{ old($key.'.'.$index.'.'.$objKey, $objValue) }}</textarea>
                                                        @else
                                                            <input type="text" name="{{ $key }}[{{ $index }}][{{ $objKey }}]" 
                                                                id="content_{{ $key }}_{{ $index }}_{{ $objKey }}" 
                                                                value="{{ old($key.'.'.$index.'.'.$objKey, $objValue) }}"
                                                                class="seo-input">
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="seo-complex-notice">
                                    Complex array structure - Edit in JSON format
                                </div>
                            @endif
                        @else
                            @if(is_string($value) && strlen($value) > 100)
                                <textarea name="{{ $key }}" id="content_{{ $key }}" rows="3"
                                    class="seo-textarea">{{ old($key, $value) }}</textarea>
                            @else
                                <input type="text" name="{{ $key }}" id="content_{{ $key }}" value="{{ old($key, $value) }}"
                                    class="seo-input">
                            @endif
                        @endif
                    </div>
                @endforeach
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