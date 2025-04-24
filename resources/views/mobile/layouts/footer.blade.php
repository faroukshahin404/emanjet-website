@php
$url = url()->current();            // Current URL without query string
$isTickets = str_contains($url, '/mobile/tickets');
$isSettings = str_contains($url, '/settings');
@endphp
<!-- start bottom navbar  -->
 <div>
    <div class="bottom-navbar">
        <a href="/" class="nav-item {{ !$isTickets && !$isSettings ? 'active' : '' }}">
            <div>
                <i class="fa fa-home"></i>
                <p>الرئيسية</p>
            </div>
        </a>
        <a href="{{route('mobile.tickets')}}" class="nav-item {{ $isTickets ? 'active' : '' }}">
            <div>
                <i class="fas fa-ticket"></i>
                <p>التذاكر</p>
            </div>
        </a>
        <a href="{{route('mobile.settings')}}" class="nav-item {{ $isSettings ? 'active' : '' }}">
            <div>
                <i class="fas fa-gear"></i>
                <p>الاعدادات</p>
            </div>
        </a>
    </div>
</div>
