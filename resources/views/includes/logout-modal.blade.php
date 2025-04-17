    <!-- log out Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true"
        data-bs-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <h5 class="text-center mb-4 text-black">هل تريد تسجيل الخروج؟</h5>
                    <form action="{{ route('auth.logout') }}" method="POST">
                        <div class="d-flex gap-4 align-items-center justify-content-center">
                            @csrf
                            <button type="submit" class="yes-btn">
                                نعم
                            </button>
                            <button type="button" class="yes-btn no-btn" data-bs-dismiss="modal">
                                لا
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
