@extends('layouts.master')

@section('mobile-content')
    <div class="d-flex justify-content-between align-items-center mb-4 wow animate__animated animate__fadeIn">
        <button type="button" onclick="window.history.back()" class="bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center border-light-subtle" style="width: 40px; height: 40px; border: 1px solid #eee;">
            @if (app()->getLocale() == 'ar')
                <i class="fas fa-arrow-right fs-16 text-black"></i>
            @else
                <i class="fas fa-arrow-left fs-16 text-black"></i>
            @endif
        </button>
        <h5 class="m-0 fw-800 text-black">{{ __('Settings') }}</h5>
        <div style="width: 40px;"></div>
    </div>

    <div class="container p-0">
        <!-- Account Section -->
        <div class="mb-4 wow animate__animated animate__fadeInUp">
            <span class="text-muted fw-800 overline-text d-block mb-3 px-1" style="font-size: 9px;">{{ __('ACCOUNT') }}</span>
            <div class="bg-white rounded-5 shadow-premium border border-light-subtle overflow-hidden">
                <a href="{{ route('profile.edit') }}" class="d-flex align-items-center justify-content-between p-3 border-bottom border-light-subtle text-decoration-none">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-main-light text-main rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="fa fa-user fs-12"></i>
                        </div>
                        <span class="fw-800 text-black small">{{ __('Edit Profile') }}</span>
                    </div>
                    <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} text-muted fs-10"></i>
                </a>

                <a href="{{ route('usage-terms') }}" class="d-flex align-items-center justify-content-between p-3 border-bottom border-light-subtle text-decoration-none">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-light text-muted rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="fa-solid fa-shield fs-12"></i>
                        </div>
                        <span class="fw-800 text-black small">{{ __('Terms and Conditions') }}</span>
                    </div>
                    <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} text-muted fs-10"></i>
                </a>

                <a href="{{ route('privacy-policy') }}" class="d-flex align-items-center justify-content-between p-3 text-decoration-none">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-light text-muted rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="fas fa-lock fs-12"></i>
                        </div>
                        <span class="fw-800 text-black small">{{ __('Privacy Policy') }}</span>
                    </div>
                    <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} text-muted fs-10"></i>
                </a>
            </div>
        </div>

        <!-- Support Section -->
        <div class="mb-4 wow animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
            <span class="text-muted fw-800 overline-text d-block mb-3 px-1" style="font-size: 9px;">{{ __('SUPPORT') }}</span>
            <div class="bg-white rounded-5 shadow-premium border border-light-subtle overflow-hidden">
                <a href="{{ route('contact-us') }}" class="d-flex align-items-center justify-content-between p-3 border-bottom border-light-subtle text-decoration-none">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="fa fa-phone fs-12"></i>
                        </div>
                        <span class="fw-800 text-black small">{{ __('Call Us') }}</span>
                    </div>
                    <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} text-muted fs-10"></i>
                </a>

                <a href="tel:{{ $contactUs['phone'] }}" class="d-flex align-items-center justify-content-between p-3 text-decoration-none">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="fa fa-headphones fs-12"></i>
                        </div>
                        <span class="fw-800 text-black small">{{ __('Hotline') }}</span>
                    </div>
                    <i class="fas fa-chevron-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }} text-muted fs-10"></i>
                </a>
            </div>
        </div>

        <!-- Preferences Section -->
        <div class="mb-4 wow animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
            <span class="text-muted fw-800 overline-text d-block mb-3 px-1" style="font-size: 9px;">{{ __('PREFERENCES') }}</span>
            <div class="bg-white rounded-5 shadow-premium border border-light-subtle overflow-hidden">
                <a href="{{ route('lang.switch', ['locale' => session('locale') == 'en' ? 'ar' : 'en']) }}" class="d-flex align-items-center justify-content-between p-3 border-bottom border-light-subtle text-decoration-none">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="fa-solid fa-language fs-12"></i>
                        </div>
                        <span class="fw-800 text-black small">{{ session('locale') == 'en' ? __('Arabic Language') : 'English Language' }}</span>
                    </div>
                    <span class="badge bg-light text-muted rounded-pill px-2 py-1 fs-10 fw-800 border border-light-subtle">{{ session('locale') == 'en' ? 'AR' : 'EN' }}</span>
                </a>

                <div class="d-flex align-items-center justify-content-between p-3 text-decoration-none" data-bs-toggle="modal" data-bs-target="#logoutModal" style="cursor: pointer">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="fa-solid fa-right-from-bracket fs-12"></i>
                        </div>
                        <span class="fw-800 text-danger small">{{ __('Logout') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered px-3">
            <div class="modal-content border-0 rounded-5 shadow-premium overflow-hidden">
                <div class="modal-body p-4 text-center">
                    <div class="bg-danger-subtle text-danger rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-right-from-bracket fs-24"></i>
                    </div>
                    <h5 class="fw-900 text-black mb-2">{{ __('Logout') }}</h5>
                    <p class="text-muted fw-800 mb-4" style="font-size: 13px;">{{ __('Are you sure you want to sign out?') }}</p>
                    
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light w-100 py-3 rounded-pill fw-800 border border-light-subtle" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <form action="{{ route('auth.logout') }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="btn btn-main w-100 py-3 rounded-pill fw-800 shadow-premium">{{ __('Logout') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
