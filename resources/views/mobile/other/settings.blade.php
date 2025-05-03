@extends('layouts.master')

@section('mobile-content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        @if (app()->getLocale() == 'ar')
            <i class="fas fa-arrow-right fs-18 text-black" onclick="window.history.back()"></i>
        @else
            <i class="fas fa-arrow-left fs-18 text-black" onclick="window.history.back()"></i>
        @endif
        <p class="m-0 fs-25 text-black">{{ __('Settings') }}</p>
        <div></div>
    </div>

    <div class="mt-3">
        <h2 class="text-black">{{ __('Account') }}</h2>
        <div class="bg-light px-2 py-3 rounded-5">
            <a href="{{ route('profile.edit') }}" class="text-black">
                <div class="d-flex justify-content-start align-items-center gap-3 mb-2">
                    <i class="fa fa-user"></i>
                    <p class="m-0">{{ __('Edit Profile') }}</p>
                </div>
            </a>
        </div>

        <div class="bg-light px-2 py-3 rounded-5">

            <a href="{{ route('usage-terms') }}" class="text-black">
                <div class="d-flex justify-content-start align-items-center gap-3 mb-2">
                    <i class="fa-solid fa-shield"></i>
                    <p class="m-0">{{ __('Terms and Conditions') }}</p>
                </div>
            </a>
        </div>

        <div class="bg-light px-2 py-3 rounded-5">

            <a href="{{ route('privacy-policy') }}" class="text-black">
                <div class="d-flex justify-content-start align-items-center gap-3 mb-2">
                    <i class="fas fa-lock"></i>
                    <p class="m-0">{{ __('Privacy Policy') }}</p>
                </div>
            </a>
        </div>

    </div>

    <div class="mt-3">
        <h2 class="text-black">
            {{ __('Call Us') }}
        </h2>

        <div class="bg-light px-2 py-3 rounded-5">
            <a href="{{ route('contact-us') }}" class="text-black">
                <div class="d-flex justify-content-start align-items-center gap-3 mb-2">
                    <i class="fa fa-phone"></i>
                    <p class="m-0">{{ __('Call Us') }}</p>
                </div>
            </a>

        </div>
        <div class="bg-light px-2 py-3 rounded-5">
            <a href="tel:{{ $contactUs['phone'] }}" class="text-black">
                <div class="d-flex justify-content-start align-items-center gap-3 mb-2">
                    <i class="fa fa-headphones"></i>
                    <p class="m-0">{{ __('Hotline') }}</p>
                </div>
            </a>
        </div>

    </div>

    <div class="mt-3">
        <h2 class="text-black">
            {{ __('Procedures') }}
        </h2>
        <div class="bg-light px-2 py-3 rounded-5">
            <a href="{{ route('lang.switch', ['locale' => session('locale') == 'en' ? 'ar' : 'en']) }}" class="text-black">
                <div class="d-flex justify-content-start align-items-center gap-3 mb-2">
                    <i class="fa-solid fa-language"></i>
                    @if (session('locale') == 'en')
                        <p class="m-0"> العربية </p>
                    @else
                        <p class="m-0"> English </p>
                    @endif
                </div>
            </a>
            <!-- #region -->
        </div>


        <div class="bg-light px-2 py-3 rounded-5">
            <div class="d-flex justify-content-start align-items-center gap-3 mb-2">
                <i class="fa-solid fa-right-from-bracket"></i>
                <p class="m-0" data-bs-toggle="modal" data-bs-target="#logoutModal" style="cursor: pointer">
                    {{ __('Logout') }}</p>
            </div>
        </div>

        <!-- log out modal  -->
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">


                <div class="modal-content d-flex flex-column align-items-center">

                    <div class="modal-body">
                        {{ __('Are you sure you want to logout?') }}
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('auth.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-main" id="confirmLogout">{{ __('Yes') }}</button>
                        </form>

                        <button type="button" class="btn btn-main-outline"
                            data-bs-dismiss="modal">{{ __('No') }}</button>
                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection
