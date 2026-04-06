@extends('admin.layouts.master')

@section('title', __('Edit Page'))

@section('breadcrumb')
    <x-admin.page-header
        :title="__('Edit Page')"
        :parent-url="route('admin.pages.index')"
        :parent-label="__('Pages')" />
@endsection

@section('content')
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

            <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <span class="form-label text-muted d-block">{{ __('Slug') }}</span>
                    <div class="rounded border bg-light px-3 py-2 text-body-secondary user-select-all" role="note">{{ $page->slug }}</div>
                </div>

                <h5 class="fw-semibold mb-3 pb-2 border-bottom">{{ __('Basic Information') }}</h5>

                <div class="row mb-3">
                    @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="title_{{ $lang }}">{{ __('Title') }} ({{ $label }})</label>
                                <input type="text" name="title[{{ $lang }}]" id="title_{{ $lang }}"
                                    value="{{ old("title.$lang", is_array($page->title) ? ($page->title[$lang] ?? '') : ($lang === 'en' ? $page->title : '')) }}"
                                    class="form-control" @if ($lang === 'ar') dir="rtl" @endif>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row mb-3">
                    @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="meta_title_{{ $lang }}">{{ __('Meta Title') }} ({{ $label }})</label>
                                <input type="text" name="meta_title[{{ $lang }}]" id="meta_title_{{ $lang }}"
                                    value="{{ old("meta_title.$lang", is_array($page->meta_title) ? ($page->meta_title[$lang] ?? '') : ($lang === 'en' ? $page->meta_title : '')) }}"
                                    class="form-control" @if ($lang === 'ar') dir="rtl" @endif>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row mb-3">
                    @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="meta_description_{{ $lang }}">{{ __('Meta Description') }} ({{ $label }})</label>
                                <textarea name="meta_description[{{ $lang }}]" id="meta_description_{{ $lang }}" rows="3" class="form-control" @if ($lang === 'ar') dir="rtl" @endif>{{ old("meta_description.$lang", is_array($page->meta_description) ? ($page->meta_description[$lang] ?? '') : ($lang === 'en' ? (string) $page->meta_description : '')) }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card border-primary border-opacity-25 shadow-sm my-4 overflow-hidden">
                    <div class="card-header bg-primary bg-opacity-10 border-bottom border-primary border-opacity-25 py-3 px-4">
                        <div class="d-flex flex-wrap align-items-start gap-3">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-2 bg-primary text-white flex-shrink-0" style="width: 2.75rem; height: 2.75rem;" aria-hidden="true">
                                <i class="bi bi-tags-fill fs-5"></i>
                            </span>
                            <div class="flex-grow-1 min-w-0">
                                <h5 class="fw-semibold mb-1">{{ __('Meta Tags') }}</h5>
                                <p class="text-muted small mb-0">{{ __('Meta tags section description') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-body-secondary bg-opacity-50 pt-4 px-4 pb-4">

                    <h6 class="fw-semibold mb-3 d-flex align-items-center gap-2 text-body">
                        <i class="bi bi-image text-primary" aria-hidden="true"></i>
                        {{ __('Meta tags: images and keywords') }}
                    </h6>

                    <div class="row mb-1">
                        @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta_tags_image_{{ $lang }}">{{ __('Image') }} ({{ $label }})</label>
                                    <input type="file" name="meta_tags_image_{{ $lang }}" id="meta_tags_image_{{ $lang }}" class="form-control">
                                    @if (isset($page->meta_tags[$lang]) && ! empty($page->meta_tags[$lang]['image']))
                                        <div class="mt-2">
                                            <img src="{{ asset($page->meta_tags[$lang]['image']) }}" alt="" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                            <p class="small text-muted mb-0">{{ basename($page->meta_tags[$lang]['image']) }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row mb-3">
                        @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta_tags_keywords_{{ $lang }}">{{ __('Keywords') }} ({{ $label }})</label>
                                    <input type="text" name="meta_tags[{{ $lang }}][keywords]" id="meta_tags_keywords_{{ $lang }}"
                                        value="{{ old("meta_tags.$lang.keywords", isset($page->meta_tags[$lang]) ? $page->meta_tags[$lang]['keywords'] : '') }}"
                                        class="form-control" @if ($lang === 'ar') dir="rtl" @endif>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <h6 class="fw-semibold mb-3 mt-2 pt-4 border-top border-secondary-subtle d-flex align-items-center gap-2 text-body">
                        <i class="bi bi-share text-primary" aria-hidden="true"></i>
                        {{ __('Meta tags: Open Graph') }}
                    </h6>
                    <p class="text-muted small mb-3">{{ __('Meta tags Open Graph hint') }}</p>

                    <div class="row mb-3">
                        @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta_tags_og_image_{{ $lang }}">{{ __('OG Image') }} ({{ $label }})</label>
                                    <input type="file" name="meta_tags_og_image_{{ $lang }}" id="meta_tags_og_image_{{ $lang }}" class="form-control">
                                    @if (isset($page->meta_tags[$lang]) && ! empty($page->meta_tags[$lang]['og_image']))
                                        <div class="mt-2">
                                            <img src="{{ asset($page->meta_tags[$lang]['og_image']) }}" alt="" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                            <p class="small text-muted mb-0">{{ basename($page->meta_tags[$lang]['og_image']) }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row mb-3">
                        @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="meta_tags_og_title_{{ $lang }}">{{ __('OG Title') }} ({{ $label }})</label>
                                    <input type="text" name="meta_tags[{{ $lang }}][og_title]" id="meta_tags_og_title_{{ $lang }}"
                                        value="{{ old("meta_tags.$lang.og_title", isset($page->meta_tags[$lang]) ? $page->meta_tags[$lang]['og_title'] : '') }}"
                                        class="form-control" @if ($lang === 'ar') dir="rtl" @endif>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="row mb-0">
                        @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                            <div class="col-md-6">
                                <div class="mb-0">
                                    <label class="form-label" for="meta_tags_og_description_{{ $lang }}">{{ __('OG Description') }} ({{ $label }})</label>
                                    <textarea name="meta_tags[{{ $lang }}][og_description]" id="meta_tags_og_description_{{ $lang }}" rows="3" class="form-control" @if ($lang === 'ar') dir="rtl" @endif>{{ old("meta_tags.$lang.og_description", isset($page->meta_tags[$lang]) ? $page->meta_tags[$lang]['og_description'] : '') }}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    </div>
                </div>

                <h5 class="fw-semibold mb-3 pb-2 border-bottom mt-4">{{ __('Page Settings') }}</h5>

                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="status" id="status" value="1" class="form-check-input" {{ $page->status ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">{{ __('Active') }}</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Update Page') }}</button>
            </form>
        </div>
    </div>
@endsection
