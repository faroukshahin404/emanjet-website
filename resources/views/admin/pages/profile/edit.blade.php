@extends('admin.layouts.master')

@section('title', __('Profile'))

@section('breadcrumb')
    <x-admin.page-header
        :title="__('Profile')"
        :parent-url="route('admin.dashboard.index')"
        :parent-label="__('Dashboard')" />
@endsection

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <h5 class="fw-semibold mb-3">{{ __('Account') }}</h5>
            <dl class="row mb-0 small">
                <dt class="col-sm-3 text-muted">{{ __('Name') }}</dt>
                <dd class="col-sm-9">{{ $admin->name }}</dd>
                <dt class="col-sm-3 text-muted">{{ __('Email') }}</dt>
                <dd class="col-sm-9">{{ $admin->email }}</dd>
            </dl>

            <hr class="my-4">

            <h5 class="fw-semibold mb-3">{{ __('Change password') }}</h5>
            <form method="POST" action="{{ route('admin.profile.password.update') }}" class="col-lg-8">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label" for="current_password">{{ __('Current password') }}</label>
                    <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                        id="current_password" name="current_password" required autocomplete="current-password">
                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">{{ __('New password') }}</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                        id="password" name="password" required autocomplete="new-password" minlength="8">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label" for="password_confirmation">{{ __('Confirm new password') }}</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        required autocomplete="new-password" minlength="8">
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Update password') }}</button>
            </form>
        </div>
    </div>
@endsection
