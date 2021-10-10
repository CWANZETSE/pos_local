<div class="nk-content ">

    <div class="card card-preview">
        <div class="card-inner">
            <div class="col-lg-12" style="text-align:center">
                <div wire:loading>
                    <div class="form-group">
                        <span class="text-danger">Please wait...</span>
                    </div>
                    <div class="spinner-border text-primary" role="status">
                    </div>
                </div>
            </div>
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <span class="preview-title-lg overline-title">discount management</span>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em
                                    class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li class="nk-block-tools-opt">
                                        <button type="button" class="btn btn-secondary"
                                                wire:click="showDiscountModal"><em class="icon ni ni-activity-alt"></em><span>View Discount Report</span></button>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div>
            <div autocomplete="off">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label" for="full-name-1">Branch</label>
                            <div class="form-note">Store offering discount</div>
                            <div class="form-control-select">
                                <select class="form-control @error('branch_id') is-invalid @enderror" id="branch_id" wire:model="branch_id">
                                    <option value="">--Select Branch--</option>
                                    @foreach($branches as $branch)
                                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label" for="full-name-1">SKU Code</label>
                            <div class="form-note">Scan product</div>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control" placeholder="" wire:model="sku_code">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="form-label" for="full-name-1">Category</label>
                            <div class="form-note">From scanned product</div>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" placeholder="" wire:model="category" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="form-label" for="full-name-1">Product</label>
                            <div class="form-note">From scanned product</div>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" placeholder="" wire:model="product" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label class="form-label" for="full-name-1">Size</label>
                            <div class="form-note">From scanned product</div>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" placeholder="" wire:model="size" disabled>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label" for="full-name-1">Cost Price</label>
                            <div class="form-note">From scanned product</div>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control @error('buying_price') is-invalid @enderror" id="buying_price" aria-describedby="name" wire:model.lazy="buying_price" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label" for="full-name-1">Normal Price</label>
                            <div class="form-note">From scanned product</div>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control @error('current_price') is-invalid @enderror" id="current_price" aria-describedby="name" wire:model.lazy="current_price" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label" for="full-name-1">Discounted Price</label>
                            <div class="form-note">Between cost price and normal price</div>
                            <div class="form-control-wrap">
                                <input type="{{$discountActive? 'text':'number'}}" {{$discountActive? 'disabled':''}} class="form-control @error('amount') is-invalid @enderror" id="amount" aria-describedby="name" wire:model.lazy="amount">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label" for="full-name-1">Expiry for Discounted Price</label>
                            <div class="form-note">Last day of this discount</div>
                            <div class="form-control-wrap focused" id="endDateDiv" data-enddate="@this">
                                <div class="form-icon form-icon-right">
                                    <em class="icon ni ni-calendar-alt"></em>
                                </div>
                                <input type="text" class="form-control form-control-outlined date-picker" id="endingDate" wire:model="date_to" required>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div id="" class=" dt-bootstrap4 no-footer">

                <div class=" my-3">
                    @if(!empty($latestDiscount))
                    <table class="nk-tb-list nk-tb-ulist no-footer" data-auto-responsive="false" id="" role="grid"
                           aria-describedby="DataTables_Table_1_info">
                        <thead>
                        <tr class="nk-tb-item nk-tb-head" role="row">

                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">Branch</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">Product</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">Size</span></th>

                            <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="Verified: activate to sort column ascending">
                                <span class="sub-text">Cost Price</span></th>
                            <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="Verified: activate to sort column ascending">
                                <span class="sub-text">Retail Price</span></th>
                            <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="Verified: activate to sort column ascending">
                                <span class="sub-text">Disc. Price</span></th>
                            <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="Verified: activate to sort column ascending">
                                <span class="sub-text">Created</span></th>
                            <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="Verified: activate to sort column ascending">
                                <span class="sub-text">Expiry</span></th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr class="nk-tb-item odd" role="row">

                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span >{{$latestDiscount?\App\Models\Branch::find($latestDiscount['branch_id'])->name:''}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$latestDiscount?\App\Models\Product::find($latestDiscount['product_id'])->name:''}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$latestDiscount?\App\Models\Size::find($latestDiscount['size_id'])->name:''}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$latestDiscount?number_format(\App\Models\Purchase::where('branch_id',$latestDiscount['branch_id'])->where('size_id',$latestDiscount['size_id'])->latest()->first()->cost,2):''}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$latestDiscount?number_format(\App\Models\Purchase::where('branch_id',$latestDiscount['branch_id'])->where('size_id',$latestDiscount['size_id'])->latest()->first()->rrp,2):''}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$latestDiscount?number_format($latestDiscount['amount'],2):''}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$latestDiscount?$latestDiscount['created_at']:''}}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$latestDiscount?$latestDiscount['expiry_date']:''}}</span>
                                            <span>{{$latestDiscount?\Carbon\Carbon::parse($latestDiscount['expiry_date'])->diffForHumans():''}}</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">

                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em
                                    class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">

                                    <li class="nk-block-tools-opt">
                                        <button type="button" class="btn btn-primary"
                                                wire:click="createDiscount" {{$attributeInBranch?"":'disabled'}}><em class="icon ni ni-cart"></em><span>Create Discount</span></button>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div>
        </div>
    </div>
    @include('modals.discountModal')
</div>
