  <!-- start header  -->
  <div class="mobileHeader d-flex justify-content-between">
      @if (auth()->check())
          <p class="m-0 text-black"> {{ __('Hello') }}, {{ auth()->user()->name }}</p>
      @else
          <p class="m-0 text-black">
              {{ __('Welcome') }}
          </p>
      @endif
      {{-- @if (auth()->check())
          <div class="mo-bell-box position-relative">
              <div class="bell-icon">
                  <p class="notification-count position-absolute m-0">1</p>
                  <i class="fa-regular fa-bell text-main fs-18"></i>
              </div>
              <div class="notifications-dropdown">
                  <div class="notification-header">
                      <h5>الإشعارات</h5>
                  </div>
                  <div class="notification-list">
                      <div class="notification-item unread">
                          <span class="notification-time">لديك رسالة جديدة</span>
                      </div>
                      <div class="notification-item">
                          <span class="notification-time">تمت الموافقة على طلبك</span>
                      </div>
                  </div>
                  <div class="notification-footer">
                      <a href="#">عرض جميع الإشعارات</a>
                  </div>
              </div>
          </div>
      @endif --}}

  </div>
