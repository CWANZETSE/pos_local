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
                        <span class="preview-title-lg overline-title">cashier sales report</span>
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

                                    <li>
                                        <div class="form-control-wrap focused">
                                            <div class="form-control-select">
                                                <select class="form-control" id="branch" wire:model="user_id.lazy">
                                                    <option value="">--Select--</option>
                                                    @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                                <label class="form-label-outlined" for="user">Cashier</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <button type="button" class="btn btn-primary" wire:click="ShowDateRangeModal()">Select Date</button>
                                    </li>
                                    <li class="{{$reportReady?'':'d-none'}}">
                                        <a href="#" class="btn btn-secondary" wire:click.prevent="downloadPDF"><em class="icon ni ni-download text-light"></em> PDF <div class="ml-3" wire:loading>
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
                                        class="sub-text">Branch</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Sale ID</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Total</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Margin</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text"></span></th>

                            </tr>
                        </thead>
                        <tbody>
                           @foreach($sales as $key=>$sale)
                            <tr class="nk-tb-item odd {{$loop->odd?'bg-light':''}}" role="row">

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
                                            <span class="tb-lead">{{$sale->branch->name}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$sale->txn_code}}</span>
                                        </div>
                                        <div class="user-info">
                                            <span class="badge badge-pill badge-outline-danger {{$sale->reversed==1?'':'d-none'}}">Reversed Sale</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{number_format($sale->total,2)}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{number_format($sale->margin,2)}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead"><a href="#" class="badge badge-pill badge-outline-secondary" wire:click.prevent="ViewSaleModal({{$sale->id}})">View Products</a></span>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
                @include('modals.ViewCashierSalesModal')
                @include('modals.ShowDateRangeModal')
                <div class="row align-items-center">
                  @if(is_array($sales)) @else  {{ $sales->links('pagination.admin') }} @endif
                </div>
            </div>
        </div>
    </div>
</div>
