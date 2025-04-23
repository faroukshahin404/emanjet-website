<div class="tab-pane fade mt-4 @if (request()->has('tap') && request()->tap == 'profile') show active @endif" id="v-pills-profile" role="tabpanel"
    aria-labelledby="v-pills-profile-tab">
    <h6 class="my-data mb-3">{{ __('My Data') }}</h6>

    <form action="{{ route('auth.update-profile') }}" method="POST">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-8 border rounded-5 px-4 py-4 bg-white shadow-sm">

                <div class="row">
                    <!-- الاسم بالكامل -->
                    <div class="col-md-6 mb-3">
                        <label class="text-black mb-2" for="name">
                            <i class="fa fa-user text-black me-1"></i> {{ __('Full Name') }}
                        </label>
                        <input class="form-control rounded-6" type="text" name="name" id="name"
                            placeholder="{{ __('Full Name') }}" value="{{ old('name', auth()->user()->name) }}">
                    </div>

                    <!-- رقم الهاتف -->
                    <div class="col-md-6 mb-3">
                        <label class="text-black mb-2" for="mobile">
                            <i class="fa fa-phone text-black me-1"></i> {{ __('Phone Number') }}
                        </label>
                        <input class="form-control rounded-6" type="text" name="mobile" id="mobile"
                            placeholder="01*******" value="{{ old('mobile', auth()->user()->mobile) }}">
                    </div>

                    <!-- النوع -->
                    <div class="col-md-6 mb-3">
                        <label class="text-black mb-2" for="gender">
                            <i class="fa-solid fa-mars text-black me-1"></i> {{ __('Gender (Optional)') }}
                        </label>
                        <select class="form-select rounded-6" name="gender" id="gender">
                            <option value="">{{ __('Select Gender') }}</option>
                            <option value="male" {{ auth()->user()->gender === 'male' ? 'selected' : '' }}>
                                {{ __('Male') }}
                            </option>
                            <option value="female" {{ auth()->user()->gender === 'female' ? 'selected' : '' }}>
                                {{ __('Female') }}
                            </option>
                        </select>
                    </div>

                    <!-- تاريخ الميلاد -->
                    <div class="col-md-6 mb-3">
                        <label class="text-black mb-2" for="birthdate">
                            <i class="fa fa-calendar text-black me-1"></i> {{ __('Birth Date (Optional)') }}
                        </label>
                        <input class="form-control rounded-6" type="date" name="birthdate" id="birthdate"
                            value="{{ old('birthdate', auth()->user()->birthdate) }}">
                    </div>

                    <!-- كلمة المرور -->
                    <div class="col-md-12 mb-3">
                        <label class="text-black mb-2" for="current_password">
                            <i class="fa fa-lock text-black me-1"></i> {{ __('Current Password (Optional)') }}
                        </label>
                        <input class="form-control rounded-6" type="password" name="current_password"
                            id="current_password"
                            placeholder="{{ __('Leave blank if you do not want to change it') }}">
                    </div>
                    <!-- كلمة المرور -->
                    <div class="col-md-12 mb-3">
                        <label class="text-black mb-2" for="password">
                            <i class="fa fa-lock text-black me-1"></i> {{ __('New Password (Optional)') }}
                        </label>
                        <input class="form-control rounded-6" type="password" name="password" id="password"
                            placeholder="{{ __('Leave blank if you do not want to change it') }}">
                    </div>
                    <!-- كلمة المرور -->
                    <div class="col-md-12 mb-3">
                        <label class="text-black mb-2" for="password_confirmation">
                            <i class="fa fa-lock text-black me-1"></i> {{ __('Confirm New Password (Optional)') }}
                        </label>
                        <input class="form-control rounded-6" type="password" name="password_confirmation"
                            id="password_confirmation"
                            placeholder="{{ __('Leave blank if you do not want to change it') }}">
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn search-trip-btn fw-bold py-2">{{ __('Save Changes') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
