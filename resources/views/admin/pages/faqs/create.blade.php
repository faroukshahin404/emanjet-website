@extends('admin.layouts.master')

@section('title', isset($item) ? __('Edit FAQ') : __('Create FAQ'))

@section('breadcrumb')
    <x-admin.page-header
        :title="isset($item) ? __('Edit FAQ') : __('Create FAQ')"
        :parent-url="route('admin.faqs.index')"
        :parent-label="__('FAQs')" />
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
                    <form method="POST" action="{{ isset($item) ? route('admin.faqs.update', $item) : route('admin.faqs.store') }}">
                        @csrf
                        @if (isset($item))
                            @method('PUT')
                        @endif

                        <div class="row mb-3">
                            @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="question_{{ $lang }}">{{ __('Question') }} ({{ $label }})</label>
                                        <input type="text" class="form-control" id="question_{{ $lang }}" name="question[{{ $lang }}]" value="{{ old("question.$lang", isset($item) ? ($item->question[$lang] ?? '') : '') }}" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row mb-3">
                            @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="answer_{{ $lang }}">{{ __('Answer') }} ({{ $label }})</label>
                                        <textarea class="form-control" id="answer_{{ $lang }}" name="answer[{{ $lang }}]" rows="10" required>{{ old("answer.$lang", isset($item) ? ($item->answer[$lang] ?? '') : '') }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="order">{{ __('Order') }}</label>
                                    <input type="number" class="form-control" id="order" name="order" value="{{ old('order', isset($item) ? $item->order : 0) }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label" for="status">{{ __('Status') }}</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="1" {{ old('status', isset($item) ? ($item->status ? '1' : '0') : '1') == '1' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                        <option value="0" {{ old('status', isset($item) ? ($item->status ? '1' : '0') : '1') == '0' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            {{ isset($item) ? __('Update') : __('Create') }}
                        </button>
                    </form>
        </div>
    </div>
@endsection
