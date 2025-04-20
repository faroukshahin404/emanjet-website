<div class="art-bg">
    <img src="{{ asset('images/art1.svg') }}" alt="" class="art-img light-img">
    <img src="{{ asset('images/art3.svg') }}" alt="" class="art-img dark-img">
</div>

<header class="main-header">
    <div class="inside-header">
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <div class="app-menu">
                
            </div>

            <div class="navbar-custom-menu r-side">
                <ul class="nav navbar-nav">
                    <li class="btn-group nav-item d-lg-inline-flex d-none">
                        <a href="#" data-provide="fullscreen"
                            class="waves-effect waves-light nav-link btn-outline no-border full-screen btn-warning-light text-white"
                            title="Full Screen">
                            <i data-feather="maximize"></i>
                        </a>
                    </li>
                    <!-- Notifications -->
                    @include('layouts.notifications')

                    <!-- User Account-->
                    <li class="dropdown user user-menu">
                        <a href="#" class="waves-effect waves-light dropdown-toggle no-border p-5"
                            data-bs-toggle="dropdown" title="User">
                            <img class="avatar avatar-pill" src="../images/avatar/3.jpg" alt="">
                        </a>
                        <ul class="dropdown-menu animated flipInX">
                            @include('layouts.settings')
                        </ul>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</header>

<!-- Left side column. contains the logo and sidebar -->
<nav class="main-nav" role="navigation">

    <!-- Mobile menu toggle button (hamburger/x icon) -->
    <input id="main-menu-state" type="checkbox" />
    <label class="main-menu-btn" for="main-menu-state">
        <span class="main-menu-btn-icon"></span> Toggle main menu visibility
    </label>
    <!-- Sample menu definition -->

</nav>
