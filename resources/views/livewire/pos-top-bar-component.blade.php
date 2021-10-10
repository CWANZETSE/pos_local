<header id="page-topbar" wire:ignore.self>
    <div class="navbar-header">
        <!-- LOGO -->
        <div class="navbar-brand-box d-flex align-items-left">
            <a href="#" class="logow">
                <img src="{{ asset('storage/logos/'.\App\Models\GeneralSetting::first()?'storage/logos/'.\App\Models\GeneralSetting::first()->logo:null) }}">
            </a>

            <button type="button" class="btn btn-sm mr-2 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>
        </div>

        <div class="d-flex align-items-center">
            <div class="dropdown d-inline-block ml-2">
                <button type="button" class="btn header-item waves-effect waves-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class=" d-sm-inline-block ml-1">@auth {{Auth::user()->name}} @endauth</span>
                    <i class="mdi mdi-chevron-down d-sm-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)" wire:click.prevent="viewChangePasswordModal">
                        <span>Change Password</span>
                    </a>
                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)" wire:click.prevent="OpenCashDrawerModal">
                        <span>Cash Drawer</span>
                    </a>
                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)" wire:click.prevent="ReprintReceiptModal">
                        <span>Reprint Receipt</span>
                    </a>
                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="javascript:void(0)" wire:click.prevent="viewDepositsModal">
                        <span>View Transactions</span>
                    </a>
                    <a class="dropdown-item d-flex text-danger align-items-center justify-content-between" href="{{ route('cashier.logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                        <span>Log Out</span>
                        <span>
                            <form id="frm-logout" action="{{ route('cashier.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </span>
                    </a>
                </div>
            </div>

        </div>
    </div>
    @include('modals.ReprintReceiptModal')
    @include('modals.DismissReprintingReceiptModal')
    @include('modals.viewOpenCashDrawerModal')
    @include('modals.closeShiftModal')
    @include('modals.cashierDepositsModal')
    @include('modals.viewTransactionSummaryModal')
    @include('modals.changePasswordModal')
</header>