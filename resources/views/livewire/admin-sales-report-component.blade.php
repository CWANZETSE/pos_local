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
            @if($errors->any())
                <div class="example-alert mb-3">
                    <div class="alert alert-danger alert-icon">
                        <em class="icon ni ni-alert-circle"></em> Please fill all required fields to generate report </div>
                </div>
            @endif
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <span class="preview-title-lg overline-title">sales report</span>
                    </div><!-- .nk-block-head-content -->
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
                                                   placeholder="Enter Sale ID" wire:model="searchCode">
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
                                        <button type="button" class="btn btn-primary" wire:click="ShowDateRangeModal()">Select Date</button>
                                    </li>
                                    <li class="{{$reportReady?'':'d-none'}}">
                                        <a href="#" class="btn btn-secondary {{$viewFilters==false?'d-none':''}}" wire:click.prevent="downloadPDF"><em class="icon ni ni-download text-light"></em> PDF <div class="ml-3" wire:loading>
                                                @include('loaders.loader6')
                                            </div>
                                        </a>
                                    </li>
                                    <li class="{{$reportReady?'':'d-none'}}">
                                        <a href="#" class="btn btn-secondary {{$viewFilters==false?'d-none':''}}" wire:click.prevent="downloadExcel"><em class="icon ni ni-download text-light"></em> Excel <div class="ml-3" wire:loading>
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
                                        class="sub-text">Date</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Sale ID</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Items</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Sale Amount (Ksh)</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Tax Amount (Ksh)</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Discount (Ksh)</span></th>
                                <th class="nk-tb-col sorting {{auth()->user()->role_id==\App\Models\Admin::IS_ADMINISTRATOR?'':'d-none'}}" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Margin (Ksh)</span></th>
                                <th class="nk-tb-col nk-tb-col-tools text-right sorting" tabindex="0"
                                    aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="
                                                            : activate to sort column ascending">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $total_margin=0;?>
                        @foreach($sales as $order)
                            <?php $sale_qty=0;?>
                            @foreach(unserialize($order->sale) as $product)
                                <?php $sale_qty+=$product['quantity'];?>
                            @endforeach
                            <?php $total_margin+=$order->margin;?>
                            <tr class="nk-tb-item odd {{$loop->odd?'bg-light':''}}" role="row">

                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{($order->created_at)}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">
                                        <div class="user-info">
                                            <span class="tb-lead">{{$order->txn_code}}</span>
                                        </div>
                                        <div class="user-info {{$order->reversed===1?"":"d-none"}}">
                                            <span class="badge badge-pill badge-outline-danger">Reversed Sale</span>
                                        </div>
                                        <div class="user-info">
                                            <code>{{$order->allow_reprint===1?"Reprint Pending":""}}</code>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">
                                        <div class="user-info">
                                            <span class="tb-lead" style="text-align:right !important;">{{$sale_qty}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead" style="text-align:right !important;">{{number_format($order->total,2)}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card text-end">

                                        <div class="user-info" style="text-align:right !important;">
                                            <span class="tb-lead">{{number_format($order->tax,2)}}</span>
                                        </div>
                                        <div class="user-info" style="text-align:right !important;">
                                            <span><small>VAT: {{$order->tax_rate}} %</small></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead" style="text-align:right !important;">{{number_format($order->total_discount,2)}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col {{auth()->user()->role_id==\App\Models\Admin::IS_ADMINISTRATOR?'':'d-none'}}">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead" style="text-align:right !important;">{{number_format($order->margin,2)}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col nk-tb-col-tools">
                                    <ul class="nk-tb-actions gx-1">

                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger"
                                                    data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li class="divider"></li>

                                                        @if($order->reversed==0)
                                                            <li wire:click.prevent="confirmReverseSale({{$order->id}})" class="">
                                                                <a href="#"><em class="icon ni ni-cart text-danger"></em><span>Reverse Sale</span></a>
                                                            </li>
                                                        @endif

                                                        <li wire:click.prevent="ViewSaleModal({{$order->id}})">
                                                            <a href="#"><em class="icon ni ni-search text-primary"></em><span>View Sale</span></a>
                                                        </li>
                                                        <li wire:click.prevent="{{$order->allow_reprint===1?"CancelReprint($order->id)":"AllowReprint($order->id)"}}">
                                                            <a href="#"><em class="icon ni ni-printer"></em><span>{{$order->allow_reprint===1?"Cancel Reprint":"Allow Reprint"}}</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                        @if(count($sales)==0)
                        <span class="text-danger">NO DATA FOUND</span>
                        @endif


                </div>
                <div class="row align-items-center">
                  @if(is_array($sales)) @else  {{ $sales->links('pagination.admin') }} @endif
                </div>
                @include('modals.saleReversalModal')
                @include('modals.adminShowSaleModal')
                @include('modals.ShowDateRangeModal')
                @include('modals.ReprintNotAllowedForReversedSale')
            </div>
        </div>
    </div>
</div>
