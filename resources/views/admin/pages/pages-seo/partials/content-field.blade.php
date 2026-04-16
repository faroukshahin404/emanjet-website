{{--
    Renders one content_json field for a single language (en|ar).
    $lang, $key, $value (null = key not defined for this language)
--}}
@php
    $langLabel = $lang === 'ar' ? __('Arabic') : __('English');
    $fieldLabel = ucfirst(str_replace(['_', '-'], ' ', $key));
@endphp

@if ($value === null)
    <div class="text-muted small py-2 border rounded bg-light px-2">{{ __('No field for this language') }}</div>
@else
    <div class="mb-0">
        <label class="form-label" for="content_{{ $lang }}_{{ $key }}">{{ $fieldLabel }} ({{ $langLabel }})</label>

        @if ($key === 'image')
            <div class="image-upload-container">
                <input type="file" name="image_uploads[{{ $lang }}][{{ $key }}]" id="content_{{ $lang }}_{{ $key }}"
                    class="dropify" accept="image/*"
                    data-default-file="{{ is_string($value) && ! empty($value) ? publicMediaUrl($value) : '' }}">
            </div>
        @elseif ($key === 'images')
            <div class="multi-image-container" id="{{ $lang }}_images_container">
                @if (is_array($value))
                    @foreach ($value as $index => $imagePath)
                        <div class="image-item mb-2">
                            <img src="{{ publicMediaUrl($imagePath) }}" alt="" class="img-thumbnail" style="max-height: 100px;">
                            <input type="hidden" name="content_json[{{ $lang }}][images][]" value="{{ $imagePath }}">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-image-btn ms-1">{{ __('Remove') }}</button>
                        </div>
                    @endforeach
                @endif
                <input type="file" name="image_uploads[{{ $lang }}][images][]" class="form-control" accept="image/*" multiple>
            </div>
            <button type="button" class="btn btn-sm btn-success mt-2 add-image-btn" data-container="{{ $lang }}_images_container">
                {{ __('Add More Images') }}
            </button>
        @elseif (is_array($value))
            @if ((isset($value[0]) && is_string($value[0])) || (is_array($value) && count($value) === 0))
                <div id="{{ $lang }}_{{ $key }}_items">
                    @foreach ($value as $index => $item)
                        @continue(! is_string($item))
                        <div class="seo-item-container border rounded p-2 mb-2 bg-light">
                            <div class="d-flex justify-content-between gap-2 align-items-center">
                                <input type="text" name="content_json[{{ $lang }}][{{ $key }}][]" value="{{ $item }}"
                                    class="form-control @if ($lang === 'ar') text-end @endif" @if ($lang === 'ar') dir="rtl" @endif>
                                <button type="button" class="btn btn-sm btn-outline-danger remove-item-btn flex-shrink-0">{{ __('Remove') }}</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-primary add-item-btn" data-container="{{ $lang }}_{{ $key }}_items" data-type="string">
                    {{ __('Add Item') }}
                </button>
            @else
                <p class="text-muted small mb-0">{{ __('This field type is not editable in this form.') }}</p>
            @endif
        @else
            @if (is_string($value) && (strlen($value) > 100 || $key === 'description'))
                <textarea 
                    name="content_json[{{ $lang }}][{{ $key }}]" 
                    id="content_{{ $lang }}_{{ $key }}" 
                    rows="10" 
                    class="form-control @if ($lang === 'ar') text-end @endif @if($key === 'description') rich-text-editor @endif" 
                    @if ($lang === 'ar') dir="rtl" @endif
                    @if($key === 'description')
                        data-editor-dir="{{ $lang === 'ar' ? 'rtl' : 'ltr' }}"
                        data-editor-lang="{{ $lang === 'ar' ? 'ar' : 'en' }}"
                    @endif
                >{{ old('content_json.'.$lang.'.'.$key, $value) }}</textarea>
            @else
                <input type="text" name="content_json[{{ $lang }}][{{ $key }}]" id="content_{{ $lang }}_{{ $key }}"
                    value="{{ old('content_json.'.$lang.'.'.$key, $value) }}" class="form-control @if ($lang === 'ar') text-end @endif" @if ($lang === 'ar') dir="rtl" @endif>
            @endif
        @endif
    </div>
@endif
