

@extends('layouts.master')

@section('mobile-content')
    <div class="mobile d-lg-none d-block" dir='{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}'>
        <div class="container mo-view mb-5 mt-3 px-4">
            <div class="row">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    @if (app()->getLocale() == 'ar')
                    <i class="fas fa-arrow-right fs-25 text-black" onclick="window.history.back()"></i>
                    @else
                    <i class="fas fa-arrow-left fs-25 text-black" onclick="window.history.back()"></i>
                    @endif
                    <p class="m-0 fs-25 text-black">{{ __('Edit Profile') }}</p>
                    <div></div>
                </div>

                <div class="mt-3">
                    <form action="{{ route('profile.update') }}" method="POST"
                        class="profile-edit-form d-flex flex-column align-items-center login-form">
                        @csrf

                        <div class="edit-profile-container text-center">
                            <div class="input-wrapper mb-3">
                                <input class="form-control text-end" type="text" name="name"
                                    value="{{ old('name', auth()->user()->name) }}">
                                <i class="fa fa-user"></i>
                            </div>

                            <div class="input-wrapper mb-3">
                                <input class="form-control text-end" type="text" name="mobile"
                                    value="{{ old('mobile', auth()->user()->mobile) }}">
                                <i class="fa fa-phone"></i>
                            </div>

                            <div class="input-wrapper mb-3">
                                <select class="form-control text-end" name="gender">
                                    <option value="">{{ __('Select Gender') }}</option>
                                    <option value="male" {{ auth()->user()->gender === 'male' ? 'selected' : '' }}>
                                        {{ __('Male') }}
                                    </option>
                                    <option value="female" {{ auth()->user()->gender === 'female' ? 'selected' : '' }}>
                                        {{ __('Female') }}
                                    </option>
                                </select>
                                <i class="fa-solid fa-venus-mars"></i>
                            </div>

                            <div class="input-wrapper mb-3">
                                <input class="form-control text-end" type="date" name="birthdate"
                                    value="{{ old('birthdate', auth()->user()->birthdate) }}">
                                <i class="fa fa-calendar"></i>
                            </div>

                            <div class="input-wrapper mb-3">
                                <input class="form-control text-end" type="password" name="current_password"
                                    placeholder="{{ __('Current Password (Optional)') }}">
                                <i class="fa fa-lock"></i>
                            </div>

                            <div class="input-wrapper mb-3">
                                <input class="form-control text-end" type="password" name="password"
                                    placeholder="{{ __('New Password (Optional)') }}">
                                <i class="fa fa-lock"></i>
                            </div>

                            <div class="input-wrapper mb-3">
                                <input class="form-control text-end" type="password" name="password_confirmation"
                                    placeholder="{{ __('Confirm New Password (Optional)') }}">
                                <i class="fa fa-lock"></i>
                            </div>

                            <button type="submit" class="btn save-changes-btn w-100">{{ __('SAVE CHANGES') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="bottom-navigation">
            <div class="nav-item">
                <i class="fa fa-home"></i>
                <span>{{ __('Home') }}</span>
            </div>
            <div class="nav-item">
                <i class="fa fa-ticket"></i>
                <span>{{ __('Tickets') }}</span>
            </div>
            <div class="nav-item active">
                <i class="fa fa-cog"></i>
                <span>{{ __('Settings') }}</span>
            </div>
        </div>

    </div>
    @push('styles')
        <style>
            .edit-profile-container {
                background-color: white;
                border-radius: 15px;
                padding: 30px 20px;
                width: 100%;
                max-width: 100%;
                margin: 0 auto;
            }

            .edit-profile-container h2 {
                font-size: 18px;
                font-weight: 600;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .input-wrapper {
                position: relative;
            }

            .form-control {
                height: 50px;
                border-radius: 10px;
                border: 1px solid #e0e0e0;
                padding: 10px 40px 10px 15px;
                font-size: 14px;
            }

            .input-wrapper i {
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: #666;
            }

            .save-changes-btn {
                background-color: #F4B41A;
                color: white;
                font-weight: bold;
                height: 50px;
                border-radius: 10px;
                margin-top: 10px;
                text-transform: uppercase;
            }

            .bottom-navigation {
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                display: flex;
                justify-content: space-around;
                background: white;
                padding: 10px 0;
                box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            }

            .nav-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                font-size: 12px;
            }

            .nav-item.active {
                color: #F4B41A;
            }
        </style>
    @endpush
@endsection
