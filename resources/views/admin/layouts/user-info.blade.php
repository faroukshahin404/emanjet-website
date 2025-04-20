<li class="user-menu">
    <div class="waves-effect  user-info">
        <i class="fa fa-arrow-down"></i>
        {{ auth()->user()->name }}
    </div>
    <ul class="dropdown-menu animated bounceIn">
        @can('show role')
            <li><a href="{{ route('roles.index') }}">
                    <i class="fa fa-shield" style="margin: 0px"></i>
                    {{ __('Roles') }}</a></li>
        @endcan
        @can('show user')
            <li> <a href="{{ route('users.index') }}"><i class="fa fa-user" style="margin: 0px"></i>
                    {{ __('Users') }}</a>
            </li>
        @endcan


        <li><a href="{{ route('password.change') }}">
                <i class="fa fa-key" style="margin: 0px"></i>
                {{ __('Change Password') }}</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <i class="fa fa-sign-out" style="margin: 0px"></i>
                    {{ __('Logout') }}</button>
            </form>
        </li>
    </ul>
</li>





@push('scripts')
    <script>
        $(document).ready(function() {
            // Toggle the user menu
            $('.user-info').on('click', function() {
                $(this).closest('.user-menu').toggleClass('active');
            });

            // Close the user menu when clicking outside
            $(document).on('click', function(event) {
                if (!$(event.target).closest('.user-menu').length) {
                    $('.user-menu').removeClass('active');
                }
            });

        });
    </script>
@endpush
