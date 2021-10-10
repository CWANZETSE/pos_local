<div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-sidebar-brand">
                        <a href="{{route('admin.home')}}" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="./images/logo.png" srcset="./images/logo2x.png 2x" alt="logo">
                            <img class="logo-dark logo-img" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                            <img class="logo-small logo-img logo-img-small" src="./images/logo-small.png" srcset="./images/logo-small2x.png 2x" alt="logo-small">
                        </a>
                    </div>
                    <div class="nk-menu-trigger mr-n2">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                                <li class="nk-menu-heading">
                                    STORE MANAGEMENT SYSTEM
                                </li>
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt"Dashboard</h6>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="{{route('admin.home')}}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-activity-round-fill text-success"></em></span>
                                        <span class="nk-menu-text">Dashboard</span>
                                    </a>
                                </li>
                                @can('allow_create')
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon"><em class="icon ni ni-building text-primary"></em></span>
                                            <span class="nk-menu-text">Branch Management</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <li class="nk-menu-item">
                                                <a href="{{route('admin.branches')}}" class="nk-menu-link"><span class="nk-menu-text">Branches</span></a>
                                            </li>
                                        </ul><!-- .nk-menu-sub -->
                                    </li>
                                @endcan
                                @can('allow_create')
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon"><em class="icon ni ni-truck text-info"></em></span>
                                            <span class="nk-menu-text">Supplier Operations</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <li class="nk-menu-item">
                                                <a href="{{route('admin.supplier')}}" class="nk-menu-link"><span class="nk-menu-text">Supplier Manage</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="{{route('admin.supplier.statement')}}" class="nk-menu-link"><span class="nk-menu-text">Supplier Statement</span></a>
                                            </li>
                                        </ul><!-- .nk-menu-sub -->
                                    </li><!-- .nk-menu-item -->
                                @endcan
                                @can('allow_create')
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-cart" style="color:#c212e5"></em></span>
                                        <span class="nk-menu-text">Product Operations</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{route('admin.category')}}" class="nk-menu-link"><span class="nk-menu-text">Category Manage</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{route('admin.product')}}" class="nk-menu-link"><span class="nk-menu-text">Product Manage</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{route('admin.size')}}" class="nk-menu-link"><span class="nk-menu-text">Size Manage</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li><!-- .nk-menu-item -->
                                @endcan

                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon"><em class="icon ni ni-growth" style="color:#114fd2"></em></span>
                                            <span class="nk-menu-text">Stock Operations</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            @can('allow_create')
                                            <li class="nk-menu-item">
                                                <a href="{{route('admin.purchase')}}" class="nk-menu-link"><span class="nk-menu-text">New Order</span></a>
                                            </li>

                                            <li class="nk-menu-item">
                                                <a href="{{route('admin.purchase.orders')}}" class="nk-menu-link"><span class="nk-menu-text">Orders Manage</span></a>
                                            </li>
                                            @endcan

                                            <li class="nk-menu-item">
                                                <a href="{{route('view.invoices')}}" class="nk-menu-link"><span class="nk-menu-text">Invoices Manage</span></a>
                                            </li>
                                            @can('allow_create')
                                            <li class="nk-menu-item">
                                                <a href="{{route('price.update')}}" class="nk-menu-link"><span class="nk-menu-text">Price Update</span></a>
                                            </li>
                                            @endcan
                                        </ul><!-- .nk-menu-sub -->
                                    </li><!-- .nk-menu-item -->

                                @can('allow_create')
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-coin-alt text-warning"></em></span>
                                        <span class="nk-menu-text">Discount Management</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{route('admin.sales.discount')}}" class="nk-menu-link"><span class="nk-menu-text">Discount</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li>
                                @endcan
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-invest" style="color:#f17765;"></em></span>
                                        <span class="nk-menu-text">Cash Declarations</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{route('admin.reconciliation')}}" class="nk-menu-link"><span class="nk-menu-text">Cash declaration</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-line-chart-up" style="color:rgba(249,7,185,0.89)"></em></span>
                                        <span class="nk-menu-text">Reports</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{route('admin.sales')}}" class="nk-menu-link"><span class="nk-menu-text">Sales</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{route('sales.returns.report')}}" class="nk-menu-link"><span class="nk-menu-text">Sales Reversals</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{route('unit.sales.report')}}" class="nk-menu-link"><span class="nk-menu-text">Unit Sales</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{route('admin.stock')}}" class="nk-menu-link"><span class="nk-menu-text">Stock</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{route('runningStock.report')}}" class="nk-menu-link"><span class="nk-menu-text">Running Stock</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{route('admin.purchase.report')}}" class="nk-menu-link"><span class="nk-menu-text">Purchase Productwise</span></a>
                                        </li>
                                        <li class="nk-menu-item">
{{--                                            <a href="{{route('purchases.returns.report')}}" class="nk-menu-link"><span class="nk-menu-text">Purchase Return Report</span></a>--}}
                                        </li>
                                        @can('allow_create')
                                        <li class="nk-menu-item">
                                            <a href="{{route('admin.cashier.report')}}" class="nk-menu-link"><span class="nk-menu-text">Cashier</span></a>
                                        </li>
                                        @endcan
                                        <li class="nk-menu-item">
                                            <a href="{{route('cashierReconciliation.report')}}" class="nk-menu-link"><span class="nk-menu-text">Cashier Reconciliation</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{route('eodReconciliation.report')}}" class="nk-menu-link"><span class="nk-menu-text">EOD Reconciliation</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li>

                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-account-setting-alt" style="color:#1223c8"></em></span>
                                        <span class="nk-menu-text">User Management</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{route('admin.users')}}" class="nk-menu-link"><span class="nk-menu-text">Users</span></a>
                                        </li>
                                        @can('allow_create')
                                        <li class="nk-menu-item">
                                            <a href="{{route('adminstrators.users')}}" class="nk-menu-link"><span class="nk-menu-text">Admins</span></a>
                                        </li>
                                        @endcan
                                    </ul><!-- .nk-menu-sub -->
                                </li>

                                @can('allow_create')
                                 <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-setting" style="color:#f90b2a"></em></span>
                                        <span class="nk-menu-text">Settings</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{route('site.settings')}}" class="nk-menu-link"><span class="nk-menu-text">Site Settings</span></a>
                                        </li>
                                    </ul><!-- .nk-menu-sub -->
                                </li>
                                @endcan
                            </ul><!-- .nk-menu -->
                        </div><!-- .nk-sidebar-menu -->
                    </div><!-- .nk-sidebar-content -->
                </div><!-- .nk-sidebar-element -->
            </div>
