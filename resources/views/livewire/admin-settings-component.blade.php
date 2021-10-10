
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
                <div class="nk-block">
                    <div class="card">
                        <div class="card-inner">
                            <ul class="nav nav-tabs mt-n3">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabItem1">General Configurations</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabItem2">Printer Configurations</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabItem3">Mail Configurations</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabItem4">Advanced Configurations</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabItem1">
                                    <form action="#" class="gy-3 form-settings">
                                        <div class="row g-3">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="site-name">Store Name</label>
                                                    <span class="form-note">Specify the name of your Store</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control @error('store_name') is-invalid @enderror" id="store_name" placeholder="My Store Limited" wire:model.lazy="state.store_name">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="store_name">Store Address</label>
                                                    <span class="form-note">Specify the address of your store.</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control @error('store_address') is-invalid @enderror" id="store_address" placeholder="Mart Address" wire:model.lazy="state.store_address">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="site-copyright">Store Footer Copyright</label>
                                                    <span class="form-note">Copyright information of your store.</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control @error('store_footer_copyright') is-invalid @enderror" id="store_footer_copyright" placeholder="© 2021, DashLite. All Rights Reserved." wire:model.lazy="state.store_footer_copyright">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row g-3">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">Store Email</label>
                                                    <span class="form-note">Specify the Email Address of your Store</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="email" class="form-control @error('store_email') is-invalid @enderror" name="store_email" placeholder="store@store.com" wire:model.lazy="state.store_email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">Store Phone</label>
                                                    <span class="form-note">Specify the Telephone Number of your Store</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control @error('store_phone') is-invalid @enderror" name="store_phone" placeholder="254**********" wire:model="state.store_phone">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">External Store Website</label>
                                                    <span class="form-note">Specify the website of your Store if external</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control @error('store_website') is-invalid @enderror" name="store_website" placeholder="www.store.com" wire:model.lazy="state.store_website">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">Tax Percentage</label>
                                                    <span class="form-note">Tax applicable to all sales</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="row">
                                                    <div class="col-lg-9">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap ">
                                                                <div class="form-control-select">
                                                                    <select class="form-control" wire:model="state.tax_percentage">
                                                                        <option value="">--Select Tax--</option>
                                                                        @foreach($tax_details as $tax)
                                                                            <option value="{{$tax->percentage}}">{{$tax->tax_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <button class="btn btn-primary" wire:click.prevent="ShowTaxModal()"><em class="icon ni ni-invest"></em></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label">Store Logo</label>
                                                    <span class="form-note">Logo will appear in receipts and Reports</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="file" class="form-control" id="logo" placeholder="0" wire:model.lazy="state.logo">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="site-off">USB Printer Name</label>
                                                    <span class="form-note">Enter the shared receipt printer name</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control @error('printer_name') is-invalid @enderror" name="printer_name" placeholder="" wire:model.lazy="state.printer_name">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="site-off">Payment Options</label>
                                                    <span class="form-note">Enabled options will be used by cashier</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="cash">Cash</label>
                                                    <div class="form-control-wrap ">
                                                        <div class="form-control-select">
                                                            <select class="form-control" wire:model="state.cash">
                                                                <option value="">--Select Mode--</option>
                                                                <option value="10">Enabled</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="mpesa">Mpesa</label>
                                                    <div class="form-control-wrap ">
                                                        <div class="form-control-select">
                                                            <select class="form-control" wire:model="state.mpesa">
                                                                <option value="13">Enabled</option>
                                                                <option value="14">Disabled</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="mpesa">KCB Pinpad</label>
                                                    <div class="form-control-wrap ">
                                                        <div class="form-control-select">
                                                            <select class="form-control" wire:model="state.kcb_pinpad">
                                                                <option value="15">Enabled</option>
                                                                <option value="16">Disabled</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-lg-12 offset-lg-10">
                                                <div class="form-group mt-2">
                                                    <button type="button" class="btn btn-lg btn-primary" wire:click="saveSettings">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="tabItem2">
                                    <p>Printer Settings</p>
                                </div>
                                <div class="tab-pane" id="tabItem3">
                                    <p>Mail settings</p>
                                </div>
                                <div class="tab-pane" id="tabItem4">
                                        Advanced Settings

                                </div>
                            </div>
                        </div>
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
    @include('modals.TaxModal')
</div>


