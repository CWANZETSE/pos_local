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
                        <span class="preview-title-lg overline-title">supplier statement</span>
                        <div class="nk-block-des text-soft">

                        </div>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em
                                    class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">

                                    <li>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="default-04"
                                                   placeholder="Enter Supplier Code" wire:model="supplier_code">
                                        </div>
                                    </li>
                                    <li>
                                        <button type="button" class="btn btn-primary" wire:click="ShowDateRangeModal()">Select Date</button>
                                    </li>
                                    <li class="{{$reportReady===true?'':'d-none'}}">
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
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-sm">
                        <tbody>
                        <tr>
                            <td>Supplier Name</td>
                            <td>{{$supplier_name}}</td>
                        </tr>
                        <tr>
                            <td>From Date</td>
                            <td>{{$date_from}}</td>
                        </tr>
                        <tr>
                            <td>To Date</td>
                            <td>{{$date_to}}</td>
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
                                    class="sub-text">Invoice</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">Description</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending" style="text-align:right !important;"><span
                                    class="sub-text">Money In</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending" style="text-align:right !important;"><span
                                    class="sub-text">Money Out</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending" style="text-align:right !important;"><span
                                    class="sub-text">Balance</span></th>

                        </tr>

                        </thead>
                        <tbody>
                            @foreach($histories as $history)
                                <tr class="nk-tb-item odd" role="row">

                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{$history->created_at}}</span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{$history->invoice_id}}</span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{$history->description}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="tb-lead" style="text-align:right !important;">{{$history->money_in!==null?number_format($history->money_in,2):''}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead" style="text-align:right !important;">{{$history->money_out!==null?'-':''}}{{$history->money_out!==null?number_format($history->money_out,2):''}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead" style="text-align:right !important;">{{number_format($history->balance,2)}}</span>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>

                @include('modals.ShowDateRangeModal')

                <div class="row align-items-center">

                </div>
            </div>
        </div>
    </div>
</div>
