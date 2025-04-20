<header class="main-header">
    <div class="inside-header">
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <div class="app-menu">
                <ul class="header-megamenu nav header-navbar">
                    <li class="btn-group d-lg-inline-flex">
                        <a href="{{ route('admin.dashboard.index') }}">
                            <div class="header-module-name">
                                م
                            </div>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="header-link dropdown-toggle" data-bs-toggle="dropdown">
                            {{ __('Dashboard') }}
                        </a>
                        <ul class="dropdown-menu animated bounceIn">
                            <li class="dropdown-item">
                                <a href="{{ route('admin.dashboard.index') }}">
                                    <i class="fa fa-shopping-cart"></i>
                                    {{ __('Purchase Requests') }}
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
            <div class="navbar-custom-menu r-side">
                <ul class="nav navbar-nav">

                    {{-- shortcuts --}}
                    <li class="nav-item d-flex align-items-center">
                        <div class="header-actions-container">
                            <!-- Container الرئيسي -->
                            <div class="actions-wrapper">
                                <!-- حقل البحث -->
                                <div class="search-field">
                                    <i class="fa fa-search search-icon"></i>
                                    <input type="text" class="search-input" placeholder="{{ __('Search') }}">
                                </div>

                                <!-- أزرار الإجراءات -->
                                <div class="action-buttons">
                                    <!-- زر الدعم -->
                                    <button class="action-btn support-btn" title="Support">
                                        <i class="fa fa-question-circle"></i>
                                    </button>

                                    <div class="shortcuts-dropdown">
                                        <button class="action-btn shortcuts-btn">
                                            <i class="fa fa-table"></i>
                                        </button>
                                        <div class="shortcuts-panel">
                                            <!-- الصف الأول -->
                                            <div class="panel-row">
                                                <div class="panel-section">
                                                    <h4 class="section-title">الموردين</h4>
                                                    <ul class="shortcuts-menu">
                                                        @can('show supplier-group')
                                                            <li>
                                                                <a href="{{ route('payable.supplier-group.index') }}">
                                                                    <i class="fa fa-tags"></i>
                                                                    انواع الموردين
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('show suppliers')
                                                            <li>
                                                                <a href="{{ route('payable.suppliers.index') }}">
                                                                    <i class="fa fa-users"></i>
                                                                    الموردين
                                                                </a>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </div>

                                                <div class="panel-section">
                                                    <h4 class="section-title">المشتريات</h4>
                                                    <ul class="shortcuts-menu">
                                                        @can('show purchase-request')
                                                            <li>
                                                                <a href="{{ route('purchasing.purchase-request.index') }}">
                                                                    <i class="fa fa-shopping-cart"></i>
                                                                    طلبات الشراء
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('show purchase-order')
                                                            <li>
                                                                <a href="{{ route('purchasing.purchase-order.index') }}">
                                                                    <i class="fa fa-file-text"></i>
                                                                    أوامر الشراء
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('show receive-orders')
                                                            <li>
                                                                <a
                                                                    href="{{ route('purchasing.receive.receive-orders.index', ['module' => 'purchasing']) }}">
                                                                    <i class="fa fa-plus"></i>
                                                                    {{ __('Add Orders') }}
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('show purchase-return')
                                                            <li>
                                                                <a
                                                                    href="{{ route('purchasing.return.purchase-return.index', ['module' => 'purchasing']) }}">
                                                                    <i class="fa fa-undo"></i>
                                                                    {{ __('Purchasing Return') }}
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('show invoice')
                                                            <li>
                                                                <a
                                                                    href="{{ route('payable.invoice.index', ['module' => 'purchasing']) }}">
                                                                    <i class="fa fa-file"></i>
                                                                    {{ __('Invoices') }}
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('show payments')
                                                            <li>
                                                                <a href="{{ route('purchasing.payments.index') }}">
                                                                    <i class="fa fa-credit-card"></i>
                                                                    {{ __('Payments') }}
                                                                </a>
                                                            </li>
                                                        @endcan

                                                    </ul>
                                                </div>
                                            </div>

                                            <!-- الصف الثاني -->
                                            <div class="panel-row">
                                                <div class="panel-section">
                                                    <h4 class="section-title">الاعدادات</h4>
                                                    <ul class="shortcuts-menu">
                                                        @can('show taxes')
                                                            <li>
                                                                <a href="{{ route('settings.taxes.index') }}">
                                                                    <i class="fa fa-percent"></i>
                                                                    الضرائب
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('show extra-cost')
                                                            <li>
                                                                <a href="{{ route('settings.extra-cost.index') }}">
                                                                    <i class="fa fa-money"></i>
                                                                    انواع المصاريف الأخري
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('show payment-methods')
                                                            <li>
                                                                <a href="{{ route('purchasing.payment-methods.index') }}">
                                                                    <i class="fa fa-credit-card"></i>
                                                                    طرق الدفع
                                                                </a>
                                                            </li>
                                                        @endcan
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    {{-- @include('admin.layouts.notifications') --}}

                    {{-- @include('admin.layouts.language-selector') --}}

                    @include('admin.layouts.user-info')

                </ul>
            </div>
        </nav>
    </div>
</header>




@push('scripts')
    <script>
        $(document).ready(function() {

            // فتح/إغلاق القائمة
            $('.shortcuts-btn').on('click', function(e) {
                e.stopPropagation();
                $(this).closest('.shortcuts-dropdown').find('.shortcuts-panel').toggleClass(
                    'show');
            });

            // إغلاق القائمة عند النقر خارجها
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.shortcuts-dropdown').length) {
                    $('.shortcuts-panel').removeClass('show');
                }
            });

            // منع إغلاق القائمة عند النقر داخلها
            $('.shortcuts-panel').on('click', function(e) {
                e.stopPropagation();
            });

        });
    </script>
@endpush
