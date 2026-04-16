@section('mobile-content')
    <div class="mobile d-lg-none d-block" dir='{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}'>
        <div class="container mo-view mb-5 mt-3 px-4">
            <div class="row">
                <div class="d-flex justify-content-between align-items-center mb-4 wow animate__animated animate__fadeIn">
                    <button type="button" onclick="window.history.back()" class="bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center border-light-subtle" style="width: 40px; height: 40px; border: 1px solid #eee;">
                        @if (app()->getLocale() == 'ar')
                            <i class="fas fa-arrow-right fs-16 text-black"></i>
                        @else
                            <i class="fas fa-arrow-left fs-16 text-black"></i>
                        @endif
                    </button>
                    <h5 class="m-0 fw-800 text-black">{{ __('Set Password') }}</h5>
                    <div style="width: 40px;"></div>
                </div>

                <div class="text-center mt-3 mb-5 wow animate__animated animate__fadeIn">
                    <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-shield-alt fs-30"></i>
                    </div>
                    <h4 class="fw-900 text-black mb-1">{{ __('New Password') }}</h4>
                    <p class="text-muted fw-800 small mb-0 px-3">
                        {{ __('Enter your new secure password below') }}
                    </p>
                </div>

                <form action="{{ route('auth.updatePassword') }}" method="POST" class="wow animate__animated animate__fadeInUp">
                    @csrf
                    <input type="hidden" name="otp" value="{{ $otp }}">

                    <div class="mb-4">
                        <label for="password" class="text-muted fw-800 overline-text mb-2 px-1 d-block" style="font-size: 9px;">{{ __('NEW PASSWORD') }}</label>
                        <div class="input-group-premium position-relative">
                            <i class="fa fa-key icon"></i>
                            <input type="password"
                                   class="form-control-premium @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="{{ __('••••••••') }}"
                                   required>
                            <i class="fas fa-eye text-muted opacity-50 pe-3" onclick="togglePassword(this)" style="position: absolute; {{ app()->getLocale() == 'ar' ? 'left: 0' : 'right: 0' }}; top: 50%; transform: translateY(-50%); cursor: pointer; z-index: 10;"></i>
                        </div>
                        @error('password')
                            <div class="invalid-feedback px-1" style="font-size: 10px; font-weight: 800;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="text-muted fw-800 overline-text mb-2 px-1 d-block" style="font-size: 9px;">{{ __('CONFIRM NEW PASSWORD') }}</label>
                        <div class="input-group-premium position-relative">
                            <i class="fa fa-key icon"></i>
                            <input type="password"
                                   class="form-control-premium"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="{{ __('••••••••') }}"
                                   required>
                            <i class="fas fa-eye text-muted opacity-50 pe-3" onclick="togglePassword(this)" style="position: absolute; {{ app()->getLocale() == 'ar' ? 'left: 0' : 'right: 0' }}; top: 50%; transform: translateY(-50%); cursor: pointer; z-index: 10;"></i>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger-subtle text-danger border-0 rounded-4 mb-4 wow animate__animated animate__shakeX">
                            <ul class="mb-0 fw-800 small py-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-5 pt-2">
                        <button type="submit" class="btn btn-main w-100 py-3 rounded-pill fw-800 shadow-premium">
                            {{ __('Update Password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @include('mobile.layouts.footer')
    </div>

    @push('scripts')
        <script>
            function togglePassword(icon) {
                const input = icon.previousElementSibling;
                if(!input) return;
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        </script>
    @endpush
@endsection
