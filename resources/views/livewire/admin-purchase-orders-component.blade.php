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
                        <span class="preview-title-lg overline-title">purchase orders</span>
                    </div><!-- .nk-block-head-content -->

                </div><!-- .nk-block-between -->
            </div>
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">

                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em
                                    class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li>
                                        <div class="form-control-wrap focused">
                                            <div class="form-control-select">
                                                <select class="form-control" id="search_type" wire:model="search_type">
                                                    <option value="filter">By Filter</option>
                                                    <option value="code">By Code</option>

                                                </select>
                                                <label class="form-label-outlined" for="branch">Search</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="{{$viewFilters==true?'d-none':''}}">
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="default-04"
                                                   placeholder="Enter Order ID" wire:model="searchCode">
                                        </div>
                                    </li>

                                        <li class="{{$viewFilters==false?'d-none':''}}">
                                            <div class="form-control-wrap focused">
                                                <div class="form-control-select">
                                                    <select class="form-control" id="branch" wire:model="branch_id">
                                                        <option value="">--Select--</option>
                                                        @foreach($branches as $branch)
                                                            <option value="{{$branch->id}}">{{$branch->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label class="form-label-outlined" for="branch">Branch</label>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="{{$viewFilters==false?'d-none':''}}">
                                            <div class="form-control-wrap focused">
                                                <div class="form-control-select">
                                                    <select class="form-control" id="branch" wire:model="supplier_id">
                                                        <option value="">--Select--</option>
                                                        <option value="0">All Suppliers</option>
                                                        @foreach($suppliers as $supplier)
                                                            <option value="{{$supplier->id}}">{{$supplier->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label class="form-label-outlined" for="branch">Supplier</label>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="{{$viewFilters==false?'d-none':''}}">
                                            <div class="form-control-wrap focused">
                                                <div class="form-control-select">
                                                    <select class="form-control" id="branch" wire:model="status_id">
                                                        <option value="">--Select--</option>
                                                        <option value="0">Pending</option>
                                                        <option value="1">Approved</option>
                                                        <option value="2">Declined</option>
                                                    </select>
                                                    <label class="form-label-outlined" for="branch">Status</label>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <button type="button" class="btn btn-primary" wire:click="ShowDateRangeModal()">Select Date</button>
                                        </li>
                                        <li class="{{$reportReady?'':'d-none'}}">
                                            <a href="#" class="btn btn-secondary {{$viewFilters==false?'d-none':''}}" wire:click.prevent="downloadPDFStatement"><em class="icon ni ni-download text-light"></em> ALL <div class="ml-3" wire:loading>
                                                    @include('loaders.loader6')
                                                </div>
                                            </a>
                                        </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div>
            <div id="" class=" dt-bootstrap4 no-footer">

                <div class=" my-3">
                    <table class="nk-tb-list nk-tb-ulist no-footer" data-auto-responsive="false" id="" role="grid"
                           aria-describedby="DataTables_Table_1_info">
                        <thead>
                        <tr class="nk-tb-item nk-tb-head" role="row">
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">ORDER NO.</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">BRANCH</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">SUPPLIER CODE</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">SUPPLIER</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">AMOUNT</span></th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php $total=0; ?>
                        @foreach($purchases as $purchase)
                            <?php $total+=$purchase->order_total; ?>
                            <tr class="nk-tb-item odd {{$loop->odd?'bg-light':''}}" role="row">
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$purchase->order_id}}</span><span> @can('allow_create') <a href="#" wire:click.prevent="{{$purchase->status==0?'OrderActionModal('.$purchase->id.')':''}}"><em class="{{$purchase->status==0?"icon ni ni-check-round text-success":""}}"></em> {{$purchase->status==0?'Action Order |':''}}</a> @endcan <a href="#" wire:click.prevent="ViewOrderModal({{$purchase->id}})"><em class="icon ni ni-search"></em> View Order</a> | <a href="#" wire:click.prevent="DownloadOrder({{$purchase->id}})"><em class="icon ni ni-file-pdf text-danger"></em> Download Order</a></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$purchase['branch']['name']}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$purchase['supplier']['supplier_code']}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$purchase['supplier']['name']}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead" style="text-align:right;">{{number_format($purchase->order_total,2)}}</span>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                        <tr class="nk-tb-item odd" role="row">
                            <td class="nk-tb-col" colspan="3">
                                <div class="user-card">

                                    <div class="user-info">
                                        <span class="tb-lead"></span>
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col">
                                <div class="user-card">

                                    <div class="user-info">
                                        <span class="tb-lead">SUBTOTAL</span>
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col">
                                <div class="user-card">

                                    <div class="user-info">
                                        <span class="tb-lead" style="text-align:right;">{{number_format($total,2)}}</span>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <tr class="nk-tb-item odd" role="row">
                            <td class="nk-tb-col" colspan="3">
                                <div class="user-card">

                                    <div class="user-info">
                                        <span class="tb-lead"></span>
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col">
                                <div class="user-card">

                                    <div class="user-info">
                                        <span class="tb-lead">TAX</span>
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col">
                                <div class="user-card">

                                    <div class="user-info">
                                        <span class="tb-lead" style="text-align:right;">0.00</span>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <tr class="nk-tb-item odd" role="row">
                            <td class="nk-tb-col" colspan="3">
                                <div class="user-card">

                                    <div class="user-info">
                                        <span class="tb-lead"></span>
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col">
                                <div class="user-card">

                                    <div class="user-info">
                                        <span class="tb-lead">TOTAL</span>
                                    </div>
                                </div>
                            </td>
                            <td class="nk-tb-col">
                                <div class="user-card">

                                    <div class="user-info">
                                        <span class="tb-lead" style="text-align:right;">{{number_format($total,2)}}</span>
                                    </div>
                                </div>
                            </td>

                        </tr>

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    @include('modals.OrderActionModal')
    @include('modals.OrderViewModal')
    @include('modals.ShowDateRangeModal')
</div>

