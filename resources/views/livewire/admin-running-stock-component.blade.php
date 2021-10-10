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
                        <span class="preview-title-lg overline-title">stock running report</span>
                    </div><!-- .nk-block-head-content -->
                    <!-- .nk-block-head-content -->
                </div>
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
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" id="default-04"
                                                       placeholder="Enter Product SKU" wire:model="searchCode">
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
                    </div>
                </div>
                <div class="row {{$reportReady?'':'d-none'}}">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <td>Category</td>
                                <td>{{$category}}</td>
                            </tr>
                            <tr>
                                <td>Product</td>
                                <td>{{$product}}</td>
                            </tr>
                            <tr>
                                <td>Size</td>
                                <td>{{$size}}</td>
                            </tr>
                            <tr>
                                <td>Date From</td>
                                <td>{{\Carbon\Carbon::parse($date_from)->toDayDateTimeString()}}</td>
                            </tr>
                            <tr>
                                <td>Date To</td>
                                <td>{{\Carbon\Carbon::parse($date_to)->toDayDateTimeString()}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
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
                                    class="sub-text">Authoriser</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">Qty</span></th>

                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">Remaining Qty</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">Action</span></th>

                        </tr>
                        </thead>
                        <tbody>
                @if(count($runningStocks)>0)
                        @foreach($runningStocks as $stock)
                                <tr class="nk-tb-item odd {{$loop->odd?'bg-light':''}}" role="row">

                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{$stock->created_at}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">@if($stock->user_id) {{App\Models\User::find($stock->user_id)->name}} @else {{App\Models\Admin::find($stock->admin_id)->name}} @endif</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">@if($stock->description==='sale') - @else + @endif{{$stock->units}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{number_format($stock->balance)}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{ucfirst(trans($stock->description))}}</span>
                                            </div>
                                        </div>
                                    </td>

                                </tr>

                        @endforeach
                @else
                    <tr class="nk-tb-item odd" role="row">

                        <td class="nk-tb-col" colspan="5">
                            <div class="user-card">

                                <div class="user-info">
                                    No Data
                                </div>
                            </div>
                        </td>
                    </tr>

                        @endif


                        </tbody>
                    </table>
                </div>
                <div class="row align-items-center">
                    @if(is_array($runningStocks)) @else  {{ $runningStocks->links('pagination.admin') }} @endif
                </div>

            </div>
                @include('modals.ShowDateRangeModal')
        </div>
    </div>
</div>
