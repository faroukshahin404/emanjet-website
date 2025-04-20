<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- <div class="user-profile">
                <div class="profile-pic">

                        <img src="{{ url('uploads/logo_pro.png') }}" alt="user">
                </div>
        </div> -->
    <!-- sidebar-->
    <section class="sidebar">
        <div class="multinav">
            <div class="multinav-scroll" style="height: 100%;">
                <!-- sidebar menu-->
                <ul class="sidebar-menu" data-widget="tree">

                    <li class="treeview">
                        <a href="javascript:void(0);">
                            <span>الأكواد الرئيسية</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="{{ request()->segment(3) == 'category' ? 'active' : '' }}"> <a
                                    href="{{ url('master-table/category') }}"><i class="icon-Commit"><span
                                            class="path1"></span><span class="path2"></span></i>الأصناف </a></li>
                        </ul>
                    </li>




                </ul>



            </div>
        </div>

    </section>
</aside>
