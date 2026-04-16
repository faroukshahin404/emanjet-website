

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
        <h5 class="m-0 fw-800 text-black">{{ __('Edit Profile') }}</h5>
        <div style="width: 40px;"></div>
    </div>

    <div class="wow animate__animated animate__fadeInUp">
        <div class="bg-white rounded-5 shadow-premium border border-light-subtle p-4 mb-4">
            <div class="text-center mb-4">
                <div class="position-relative d-inline-block">
                    <div class="bg-light text-main rounded-circle d-flex align-items-center justify-content-center mx-auto shadow-sm" style="width: 80px; height: 80px; border: 4px solid #fff;">
                        <i class="fa fa-user fs-30"></i>
                    </div>
                    <div class="position-absolute bottom-0 end-0 bg-main text-white rounded-circle d-flex align-items-center justify-content-center border border-white" style="width: 24px; height: 24px;">
                        <i class="fa fa-pencil fs-10"></i>
                    </div>
                </div>
                <h6 class="mt-3 mb-1 fw-900 text-black">{{ auth()->user()->name }}</h6>
                <p class="text-muted fw-800 small mb-0">{{ auth()->user()->mobile }}</p>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" class="row g-3">
                @csrf
                
                <div class="col-12">
                    <label class="text-muted fw-800 overline-text mb-2 px-1 d-block" style="font-size: 9px;">{{ __('FULL NAME') }}</label>
                    <div class="input-group-premium">
                        <i class="fa fa-user icon"></i>
                        <input type="text" name="name" class="form-control-premium" value="{{ old('name', auth()->user()->name) }}" placeholder="{{ __('Enter your name') }}">
                    </div>
                </div>

                <div class="col-12">
                    <label class="text-muted fw-800 overline-text mb-2 px-1 d-block" style="font-size: 9px;">{{ __('MOBILE NUMBER') }}</label>
                    <div class="input-group-premium">
                        <i class="fa fa-phone icon"></i>
                        <input type="text" name="mobile" class="form-control-premium" value="{{ old('mobile', auth()->user()->mobile) }}" placeholder="{{ __('Enter your mobile') }}">
                    </div>
                </div>

                <div class="col-12">
                    <label class="text-muted fw-800 overline-text mb-2 px-1 d-block" style="font-size: 9px;">{{ __('GENDER') }}</label>
                    <div class="input-group-premium">
                        <i class="fa-solid fa-venus-mars icon"></i>
                        <select class="form-control-premium select-arrow" name="gender">
                            <option value="">{{ __('Select Gender') }}</option>
                            <option value="male" {{ auth()->user()->gender === 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                            <option value="female" {{ auth()->user()->gender === 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-12">
                    <label class="text-muted fw-800 overline-text mb-2 px-1 d-block" style="font-size: 9px;">{{ __('BIRTHDATE') }}</label>
                    <div class="input-group-premium">
                        <i class="fa fa-calendar icon"></i>
                        <input type="date" name="birthdate" class="form-control-premium text-uppercase" value="{{ old('birthdate', auth()->user()->birthdate) }}">
                    </div>
                </div>

                <div class="col-12 mt-4 pt-3 border-top border-light-subtle">
                    <label class="text-muted fw-800 overline-text mb-3 px-1 d-block" style="font-size: 9px;">{{ __('SECURITY') }}</label>
                    
                    <div class="mb-3">
                        <div class="input-group-premium">
                            <i class="fa fa-lock icon"></i>
                            <input type="password" name="current_password" class="form-control-premium" placeholder="{{ __('Current Password') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="input-group-premium">
                            <i class="fa fa-lock icon"></i>
                            <input type="password" name="password" class="form-control-premium" placeholder="{{ __('New Password') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="input-group-premium">
                            <i class="fa fa-lock icon"></i>
                            <input type="password" name="password_confirmation" class="form-control-premium" placeholder="{{ __('Confirm New Password') }}">
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-main w-100 py-3 rounded-pill fw-800 shadow-premium">
                        {{ __('SAVE CHANGES') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
