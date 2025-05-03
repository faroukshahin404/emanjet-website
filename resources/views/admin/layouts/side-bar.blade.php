<aside class="main-sidebar">
    <section class="sidebar position-relative">
        <div class="multinav">
            <div class="multinav-scroll" style="height: 100%;">
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="treeview">
                        <a href="#">
                            <i data-feather="monitor"></i>
                            <span>Dashboard</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('admin.pages.index') }}"><i class="icon-Commit"><span
                                            class="path1"></span><span
                                            class="path2"></span></i>{{ __('Pages') }}</a></li>
                            <li><a href="{{ route('admin.cities.index') }}"><i class="icon-Commit"><span
                                            class="path1"></span><span
                                            class="path2"></span></i>{{ __('Cities') }}</a></li>
                            <li><a href="{{ route('admin.stations.index') }}"><i class="icon-Commit"><span
                                            class="path1"></span><span
                                            class="path2"></span></i>{{ __('Stations') }}</a></li>
                            <li><a href="{{ route('admin.blog-categories.index') }}"><i class="icon-Commit"><span
                                            class="path1"></span><span
                                            class="path2"></span></i>{{ __('Blog Categories') }}</a></li>
                            <li><a href="{{ route('admin.blogs.index') }}"><i class="icon-Commit"><span
                                            class="path1"></span><span
                                            class="path2"></span></i>{{ __('Blogs') }}</a></li>
                            <li>
                                <a href="{{ route('admin.bus-categories.index') }}"><i class="icon-Commit">
                                        <span class="path1"></span>
                                        <span class="path2"></span></i>{{ __('Bus Categories') }}</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.destinations.index') }}"><i class="icon-Commit">
                                        <span class="path1"></span>
                                        <span class="path2"></span></i>{{ __('Destinations') }}</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</aside>
