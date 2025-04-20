<li class="user-body">
    @can('show role')
        <a class="dropdown-item" href="{{ route('roles.index') }}"><i class="ti-settings text-muted me-2"></i>
            {{ __('Roles') }}</a>
    @endcan
    @can('show user')
        <a class="dropdown-item" href="{{ route('users.index') }}"><i class="ti-settings text-muted me-2"></i>
            {{ __('Users') }}</a>
    @endcan

    <a class="dropdown-item" href="{{ route('password.change') }}"><i class="ti-settings text-muted me-2"></i>
        {{ __('Change Password') }}</a>
    <div class="dropdown-divider"></div>
    <form action="{{ route('logout') }}" method="POST" style="width: 100%">
        @csrf
        @method('POST')
        <button class="dropdown-item" style="width: 100%"><i
                class="ti-lock text-muted me-2"></i>{{ __('Logout') }}</button>
    </form>
</li>
