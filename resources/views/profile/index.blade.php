@extends('layouts.master')

@section('content')
    <div class="profile-page mb-5">
        <div class="container-fluid pt-3">
            <div class="row">
                <div class="col-md-12 text-center mb-1 text-black">
                </div>
                <div class="col-md-3 mt-5 pt-4">
                    <div class="d-flex align-items-start border rounded-5 px-3 py-3">
                        <div class="nav w-100 flex-column nav-pills" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <p>{{ __('Welcome') }}, {{ auth()->user()->name }}</p>
                            <button
                                class="nav-link w-100  @if (request()->has('tap')) {{ request()->tap == 'trips' ? 'active' : '' }} @else active @endif d-flex justify-content-between align-items-center"
                                id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button"
                                role="tab" aria-controls="v-pills-home" aria-selected="true">
                                <div>
                                    <i class="fas fa-receipt mx-2"></i>
                                    <span>{{ __('My Trips') }}</span>
                                </div>
                                <div>
                                    <i class="fas fa-angle-left"></i>
                                </div>
                            </button>
                            <button
                                class="nav-link @if (request()->has('tap')) {{ request()->tap == 'profile' ? 'active' : '' }} @endif d-flex justify-content-between align-items-center"
                                id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile"
                                type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                                <div>
                                    <i class="fas fa-user mx-2"></i>
                                    <span>{{ __('Profile') }}</span>
                                </div>
                                <div>
                                    <i class="fas fa-angle-left"></i>
                                </div>
                            </button>
                            <button class="logout" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <i class="fas fa-sign-out-alt mx-2"></i>
                                <span>{{ __('Logout') }}</span>
                            </button>
                            {{-- <button class="logout" data-bs-toggle="modal" data-bs-target="#cancelModal">
                                مودال الغاء الحجز
                            </button> --}}
                        </div>

                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content" id="v-pills-tabContent">

                        @include('profile.includes.my-trips')

                        @include('profile.includes.profile')
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- @include('profile.includes.cancel-trip-modal') --}}
@endsection
@section('mobile-content')
    @include('profile.includes.my-trips-mobile')
@endsection
