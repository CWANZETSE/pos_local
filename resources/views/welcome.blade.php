<div class="nk-content ">

    <div class="card card-preview">
        <div class="card-inner">
            @if($errors->any())
                <div class="example-alert mb-3">
                    <div class="alert alert-danger alert-icon">
                        <em class="icon ni ni-alert-circle"></em> Please fill all required fields to generate report </div>
                </div>
            @endif
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title">Sales Report</h5>
                        <div class="nk-block-des text-soft">
                                                <p>Total of {{$count}} Records</p>
                                            </div>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em
                                    class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li class="{{$reportReady?'':'d-none'}}">
                                        <div class="form-control-wrap focused">
                                            <div class="form-control-select">
                                                <select class="form-control" id="printMode" wire:model="printMode">
                                                    <option value="">--Select Mode--</option>
                                                    <option value="pdf">PDF</option>
                                                    <option value="pdf">XML</option>
                                                    <option value="pdf">Excel</option>
                                                    
                                                </select>
                                                <label class="form-label-outlined" for="printMode">Print</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
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
                                    <li>
                                        
                                        <div class="form-control-wrap focused" id="startDateDiv" data-startdate="@this">
                                            <div class="form-icon form-icon-right">
                                                <em class="icon ni ni-calendar-alt"></em>
                                            </div>
                                            <input type="text" class="form-control form-control-outlined date-picker" id="startingDate" wire:model.defer="date_from" required>
                                            <label class="form-label-outlined" for="outlined-date-picker1">From</label>
                                        </div>
                                           
                                    </li>
                                    <li>
                                        
                                        <div class="form-control-wrap focused" id="endDateDiv" data-enddate="@this">
                                            <div class="form-icon form-icon-right">
                                                <em class="icon ni ni-calendar-alt"></em>
                                            </div>
                                            <input type="text" class="form-control form-control-outlined date-picker" id="endingDate" wire:model="date_to" required>
                                            <label class="form-label-outlined" for="outlined-date-picker2">To</label>
                                        </div>
                                           
                                    </li>
                                    <li class="nk-block-tools-opt">
                                        <button type="button" class="btn btn-primary"
                                            wire:click="GenerateSalesReport"><em
                                                class="icon ni ni-activity-round"></em><span>Generate Report</span></button>
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
                                        class="sub-text">Txn ID</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">SKU</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Name</span></th>

                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Size</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Price</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Qty</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Amount</span></th>
                                
                                <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="Verified: activate to sort column ascending">
                                    <span class="sub-text">Cashier</span></th>
                                <th class="nk-tb-col nk-tb-col-tools text-right sorting" tabindex="0"
                                    aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="
                                                            : activate to sort column ascending">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($sales as $key=>$sale)
                           @foreach(unserialize($sale->sale) as $item_key=>$detail)
                            <tr class="nk-tb-item odd" role="row">
                                
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$sale->created_at}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$sale->txn_code}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$detail['sku']}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$detail['product_name']}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$detail['size']}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{number_format($detail['price'],2)}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$detail['quantity']}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{number_format(($detail['price']*$detail['quantity']),2)}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$sale->user->name}}</span>
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
                                                        <li><a><span>Main Transaction Total: Ksh {{number_format($sale->total,2)}}</span></a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        
                                                        <li><a href="#"><em
                                                                    class="icon ni ni-activity-round"></em><span>Reverse Product</span></a>
                                                        </li>
                                                        <li><a href="#"><em
                                                                    class="icon ni ni-activity-round"></em><span>Reprint Receipt</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                            @endforeach
                            

                        </tbody>
                    </table>
                </div>
                <div class="row align-items-center">
                    PAGINATE
                </div>
            </div>
        </div>
    </div>
</div>