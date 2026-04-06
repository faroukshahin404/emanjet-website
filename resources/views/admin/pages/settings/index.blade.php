@extends('admin.layouts.master')

@section('title', __('Settings'))

@section('breadcrumb')
    <x-admin.page-header :title="__('Settings')" />
@endsection

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        {{-- App Links Section --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom d-flex align-items-center gap-2 py-3">
                <i class="bi bi-phone-fill text-primary"></i>
                <h5 class="mb-0 fw-semibold">{{ __('Mobile App Links') }}</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    {{-- Android --}}
                    <div class="col-12">
                        <div class="p-3 rounded-3 border bg-light">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i class="bi bi-google-play fs-5 text-success"></i>
                                <h6 class="fw-bold mb-0">Android (Google Play)</h6>
                                <div class="ms-auto form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="app_android_active"
                                        id="app_android_active" value="1"
                                        {{ $settings['app_android_active'] == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="app_android_active">{{ __('Active') }}</label>
                                </div>
                            </div>
                            <div>
                                <label for="app_android_link" class="form-label fw-semibold small">{{ __('Google Play Link') }}</label>
                                <input type="url" id="app_android_link" name="app_android_link"
                                    class="form-control @error('app_android_link') is-invalid @enderror"
                                    value="{{ old('app_android_link', $settings['app_android_link']) }}"
                                    placeholder="https://play.google.com/store/apps/details?id=...">
                                @error('app_android_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- iOS --}}
                    <div class="col-12">
                        <div class="p-3 rounded-3 border bg-light">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i class="bi bi-apple fs-5 text-dark"></i>
                                <h6 class="fw-bold mb-0">iOS (App Store)</h6>
                                <div class="ms-auto form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="app_ios_active"
                                        id="app_ios_active" value="1"
                                        {{ $settings['app_ios_active'] == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="app_ios_active">{{ __('Active') }}</label>
                                </div>
                            </div>
                            <div>
                                <label for="app_ios_link" class="form-label fw-semibold small">{{ __('App Store Link') }}</label>
                                <input type="url" id="app_ios_link" name="app_ios_link"
                                    class="form-control @error('app_ios_link') is-invalid @enderror"
                                    value="{{ old('app_ios_link', $settings['app_ios_link']) }}"
                                    placeholder="https://apps.apple.com/app/...">
                                @error('app_ios_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    {{ __('If both links are inactive or empty, the download modal and footer badges will be hidden automatically.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Booking Settings Section --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom d-flex align-items-center gap-2 py-3">
                <i class="bi bi-clock-fill text-warning"></i>
                <h5 class="mb-0 fw-semibold">{{ __('Booking Settings') }}</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="booking_hours_before_departure" class="form-label fw-semibold">
                            {{ __('Minimum Hours Before Departure to Allow Booking') }}
                        </label>
                        <div class="input-group">
                            <input type="number" id="booking_hours_before_departure"
                                name="booking_hours_before_departure"
                                class="form-control @error('booking_hours_before_departure') is-invalid @enderror"
                                value="{{ old('booking_hours_before_departure', $settings['booking_hours_before_departure']) }}"
                                min="0" max="72" step="1">
                            <span class="input-group-text">{{ __('Hours') }}</span>
                            @error('booking_hours_before_departure')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text text-muted mt-1">
                            <i class="bi bi-info-circle me-1"></i>
                            {{ __('Example: 8 means users can only book trips departing at least 8 hours from now. Set to 0 to allow booking any available trip.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary px-5">
                <i class="bi bi-save me-2"></i>{{ __('Save Changes') }}
            </button>
        </div>
    </form>
@endsection
