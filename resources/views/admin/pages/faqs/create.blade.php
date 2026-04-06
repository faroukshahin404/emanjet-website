@extends('admin.layouts.master')

@section('title', isset($item) ? __('Edit FAQ') : __('Create FAQ'))

@section('breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="box p-3 mb-3">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/"><i class="mdi mdi-home-outline"></i></a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index') }}">{{ __('Dashboard') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.faqs.index') }}">{{ __('FAQs') }}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ isset($item) ? __('Edit FAQ') : __('Create FAQ') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-body">
                    <form method="POST" action="{{ isset($item) ? route('admin.faqs.update', $item) : route('admin.faqs.store') }}">
                        @csrf
                        @if (isset($item))
                            @method('PUT')
                        @endif

                        <div class="row mb-3">
                            @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="question_{{ $lang }}">{{ __('Question') }} ({{ $label }})</label>
                                        <input type="text" class="form-control" id="question_{{ $lang }}" name="question[{{ $lang }}]" value="{{ old("question.$lang", $item->question[$lang] ?? '') }}" required>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row mb-3">
                            @foreach (['en' => 'English', 'ar' => 'Arabic'] as $lang => $label)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="answer_{{ $lang }}">{{ __('Answer') }} ({{ $label }})</label>
                                        <textarea class="form-control" id="answer_{{ $lang }}" name="answer[{{ $lang }}]" rows="4" required>{{ old("answer.$lang", $item->answer[$lang] ?? '') }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="order">{{ __('Order') }}</label>
                                    <input type="number" class="form-control" id="order" name="order" value="{{ old('order', $item->order ?? 0) }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">{{ __('Status') }}</label>
                                    <select class="form-control" id="status" name="status" required>
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
        </div>
    </div>
@endsection
