<div class="tab-pane fade mt-4 @if (request()->has('tap') && request()->tap == 'profile') show active @endif" id="v-pills-profile" role="tabpanel"
    aria-labelledby="v-pills-profile-tab">
    <h6 class="my-data mb-3">بياناتي</h6>

    <form action="{{ route('auth.update-profile') }}" method="POST">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-8 border rounded-5 px-4 py-4 bg-white shadow-sm">

                <div class="row">
                    <!-- الاسم بالكامل -->
                    <div class="col-md-6 mb-3">
                        <label class="text-black mb-2" for="name">
                            <i class="fa fa-user text-black me-1"></i> الاسم بالكامل
                        </label>
                        <input class="form-control rounded-6" type="text" name="name" id="name"
                            placeholder="الإسم بالكامل" value="{{ old('name', auth()->user()->name) }}">
                    </div>

                    <!-- رقم الهاتف -->
                    <div class="col-md-6 mb-3">
                        <label class="text-black mb-2" for="mobile">
                            <i class="fa fa-phone text-black me-1"></i> رقم الهاتف
                        </label>
                        <input class="form-control rounded-6" type="text" name="mobile" id="mobile"
                            placeholder="01*******" value="{{ old('mobile', auth()->user()->mobile) }}">
                    </div>

                    <!-- النوع -->
                    <div class="col-md-6 mb-3">
                        <label class="text-black mb-2" for="gender">
                            <i class="fa-solid fa-mars text-black me-1"></i> النوع (اختياري)
                        </label>
                        <select class="form-select rounded-6" name="gender" id="gender">
                            <option value="">اختر النوع</option>
                            <option value="male" {{ auth()->user()->gender === 'male' ? 'selected' : '' }}>ذكر
                            </option>
                            <option value="female" {{ auth()->user()->gender === 'female' ? 'selected' : '' }}>أنثى
                            </option>
                        </select>
                    </div>

                    <!-- تاريخ الميلاد -->
                    <div class="col-md-6 mb-3">
                        <label class="text-black mb-2" for="birthdate">
                            <i class="fa fa-calendar text-black me-1"></i> تاريخ الميلاد (اختياري)
                        </label>
                        <input class="form-control rounded-6" type="date" name="birthdate" id="birthdate"
                            value="{{ old('birthdate', auth()->user()->birthdate) }}">
                    </div>

                    <!-- كلمة المرور -->
                    <div class="col-md-12 mb-3">
                        <label class="text-black mb-2" for="current_password">
                            <i class="fa fa-lock text-black me-1"></i> كلمة المرور الحالية (اختياري)
                        </label>
                        <input class="form-control rounded-6" type="password" name="current_password"
                            id="current_password" placeholder="اتركها فارغة إذا لا تريد تغييرها">
                    </div>
                    <!-- كلمة المرور -->
                    <div class="col-md-12 mb-3">
                        <label class="text-black mb-2" for="password">
                            <i class="fa fa-lock text-black me-1"></i> كلمة المرور (اختياري)
                        </label>
                        <input class="form-control rounded-6" type="password" name="password" id="password"
                            placeholder="اتركها فارغة إذا لا تريد تغييرها">
                    </div>
                    <!-- كلمة المرور -->
                    <div class="col-md-12 mb-3">
                        <label class="text-black mb-2" for="password_confirmation">
                            <i class="fa fa-lock text-black me-1"></i>تأكيد كلمة المرور (اختياري)
                        </label>
                        <input class="form-control rounded-6" type="password" name="password_confirmation"
                            id="password_confirmation" placeholder="اتركها فارغة إذا لا تريد تغييرها">
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn search-trip-btn fw-bold py-2">حفظ التغييرات</button>
                </div>
            </div>
        </div>
    </form>
</div>
