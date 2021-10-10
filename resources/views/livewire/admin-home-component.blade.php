<div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="col-lg-12" style="text-align:center">
                                <div wire:loading>
                                    <div class="form-group">
                                        <span class="text-danger">Please wait...</span>
                                    </div>
                                    <div class="spinner-border text-primary" role="status">
                                    </div>
                                </div>
                            </div>
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Dashboard</h3>
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-bslock-head-content">
                                            <div class="toggle-wrap nk-block-tools-toggle">
                                                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="row g-gs">
                                        <div class="col-xxl-3 col-sm-3">
                                            <div class="card">
                                                <div class="nk-ecwg nk-ecwg6">
                                                    <div class="card-inner">
                                                        <div class="card-title-group">
                                                            <div class="card-title">
                                                                <span class="preview-title-lg overline-title">sales (Ksh)</span>
                                                            </div>
                                                        </div>
                                                        <div class="data">
                                                            <div class="title">Today</div>
                                                            <div class="amount amount-sm">{{number_format($SalesToday,2)}}</div>
                                                        </div>
                                                    </div><!-- .card-inner -->
                                                </div><!-- .nk-ecwg -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        <div class="col-xxl-3 col-sm-3">
                                            <div class="card">
                                                <div class="nk-ecwg nk-ecwg6">
                                                    <div class="card-inner">
                                                        <div class="card-title-group">
                                                            <div class="card-title">
                                                                <span class="preview-title-lg overline-title">sales (Ksh)</span>
                                                            </div>
                                                        </div>
                                                        <div class="data">
                                                            <div class="title">This Week</div>
                                                            <div class="amount amount-sm">{{number_format($SalesThisWeek,2)}}</div>
                                                        </div>
                                                    </div><!-- .card-inner -->
                                                </div><!-- .nk-ecwg -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        <div class="col-xxl-3 col-sm-3">
                                            <div class="card">
                                                <div class="nk-ecwg nk-ecwg6">
                                                    <div class="card-inner">
                                                        <div class="card-title-group">
                                                            <div class="card-title">
                                                                <span class="preview-title-lg overline-title">pending invoices</span>
                                                            </div>
                                                        </div>
                                                        <div class="data">
                                                            <div class="title" wire:click.prevent="ViewPendingInvoiceModal()" style="cursor: pointer;color:#cb15cf;">View</div>
                                                            <div class="amount amount-sm">{{$pending_invoices_count}}</div>
                                                        </div>
                                                    </div><!-- .card-inner -->
                                                </div><!-- .nk-ecwg -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        <div class="col-xxl-3 col-sm-3">
                                            <div class="card">
                                                <div class="nk-ecwg nk-ecwg6">
                                                    <div class="card-inner">
                                                        <div class="card-title-group">
                                                            <div class="card-title">
                                                                <span class="preview-title-lg overline-title">pending orders</span>
                                                            </div>
                                                        </div>
                                                    <div class="data">
                                                        <div class="title" wire:click.prevent="ViewPendingOrdersModal()" style="cursor: pointer;color:#cb15cf;">View</div>
                                                        <div class="amount amount-sm">{{$pending_orders_count}}</div>
                                                    </div>
                                                    </div><!-- .card-inner -->
                                                </div><!-- .nk-ecwg -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        <div class="col-xxl-12 col-md-12">
                                            <div class="card h-100">
                                                <div class="card-inner">
                                                    <div class="card-title-group mb-2">
                                                        <div class="card-title">
                                                            <span class="preview-title-lg overline-title">today summary</span>
                                                        </div>
                                                    </div>
                                                    <div class="analytic-data-group analytic-au-group g-3">
                                                            <div class="analytic-data analytic-au-data">
                                                                <div class="title">Stores</div>
                                                                <div class="amount">{{$stores}}</div>
                                                                <em class="icon dashcon bg-purple-dim ni ni-building"></em>
                                                            </div>
                                                            <div class="analytic-data analytic-au-data">
                                                                <div class="title">Cash Today</div>
                                                                <div class="amount">{{$cashToday}}</div>
                                                                <em class="icon dashcon bg-primary-dim ni ni-money"></em>
                                                            </div>
                                                            <div class="analytic-data analytic-au-data">
                                                                <div class="title">Mpesa Today</div>
                                                                <div class="amount">{{$mpesaToday}}</div>
                                                                <em class="icon dashcon bg-success-dim ni ni-globe"></em>
                                                            </div>
                                                            <div class="analytic-data analytic-au-data">
                                                                <div class="title">Card Today</div>
                                                                <div class="amount">{{$cardToday}}</div>
                                                                <em class="icon dashcon bg-primary-dim ni ni-mc"></em>
                                                            </div>
                                                            <div class="analytic-data analytic-au-data">
                                                                <div class="title">Sales Today</div>
                                                                <div class="amount">{{$salesToday}}</div>
                                                                <em class="icon dashcon bg-warning-dim ni ni-cart"></em>
                                                            </div>
                                                            <div class="analytic-data analytic-au-data">
                                                                <div class="title">Sales Return Today</div>
                                                                <div class="amount">{{$salesReturn}}</div>
                                                                <em class="icon dashcon bg-danger-dim ni ni-cart-fill"></em>
                                                            </div>
                                                        </div>

                                                </div><!-- .card-inner -->
                                            </div>
                                            @include('modals.ViewPendingInvoiceModal')
                                            @include('modals.ViewPendingOrdersModal')
                                        </div>


                                    </div><!-- .row -->
                                </div><!-- .nk-block -->
                            </div>
                        </div>
                    </div>
                </div>
