@extends('layouts.master')

@section('mobile-content')
<div class="mobile d-lg-none d-block" dir='rtl'>
    <div class="container mo-view mb-5 mt-3 px-4">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <i class="fas fa-arrow-right fs-25 text-black" onclick="window.history.back()"></i>

                <p class="m-0 fs-25 text-black">{{__('Edit Profile')}}</p>
                <div></div>
            </div>

            <div class="mt-3">
                <form action="{{ route('profile.update') }}" method="POST" class="profile-edit-form d-flex flex-column align-items-center login-form">
                    @csrf
                   
                    

                    <div class="position-relative mb-3 w-100">
                        <i class="fa fa-user position-absolute top-50 translate-middle-y"></i>
                        <input class="form-control rounded-6 ps-4 @error('name') is-invalid @enderror"
                               type="text"
                               name="name"
                               value="{{ old('name', auth()->user()->name) }}"
                               placeholder="{{__('Name')}}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="position-relative w-100">
                        <i class="fa fa-envelope position-absolute top-50 translate-middle-y"></i>
                        <input class="form-control rounded-6 ps-4 @error('email') is-invalid @enderror"
                               type="text"
                               name="email"
                               value="{{ old('email', auth()->user()->email) }}"
                               placeholder="{{__('Email')}}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 d-flex justify-content-center align-items-center mb-3 w-100 mt-3">
                        <button type="submit" class="btn btn-main w-100 rounded-6">{{__('Save Changes')}}</button>
                    </div>

                  
                </form>
            </div>
        </div>
    </div>
    @include('mobile.layouts.footer')
</div>

@push('styles')
<style>
    .profile-img-container {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        position: relative;
    }

    .profile-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-img-container i {
        position: absolute;
        bottom: 0;
        right: 0;
        background: var(--main-color);
        color: white;
        padding: 8px;
        border-radius: 50%;
        cursor: pointer;
    }

    .form-control {
        padding-right: 40px;
        height: 50px;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: var(--main-color);
    }

    .btn-main {
        background: var(--main-color);
        color: white;
        border: none;
        height: 50px;
    }

    .btn-outline-secondary {
        border: 1px solid #ddd;
        color: #666;
        height: 50px;
    }

    .btn-outline-secondary:hover {
        background: #f8f9fa;
        color: #666;
    }
</style>
@endpush
@endsection
