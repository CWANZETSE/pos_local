{{--<div class="modal fade zoom" tabindex="-1" id="TransactionsSummaryModal" wire:ignore.self>--}}
{{--    <div class="modal-dialog modal-lg" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-body">--}}

{{--                <div class="timeline">--}}
{{--                    <ul class="nav nav-tabs">--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link active" data-toggle="tab" href="#tabItem1"><em class="icon ni ni-bar-chart-alt mr-1"></em> TRANSACTIONS</a>--}}
{{--                        </li>--}}

{{--                    </ul>--}}
{{--                    <div class="tab-content">--}}
{{--                        <div class="tab-pane active" id="tabItem1">--}}
{{--                            <div class="col-lg-12">--}}
{{--                                <div id="" class=" dt-bootstrap4 no-footer">--}}

{{--                                    <div class="table-wrapper my-3" style="overflow-x: auto;">--}}
{{--                                        <table class="nk-tb-list nk-tb-ulist no-footer" data-auto-responsive="false"--}}
{{--                                            id="" role="grid" aria-describedby="DataTables_Table_1_info" >--}}
{{--                                            <thead class="bg-primary-light">--}}
{{--                                                <tr class="nk-tb-item nk-tb-head" role="row">--}}
{{--                                                    <th class="nk-tb-col sorting" tabindex="0"--}}
{{--                                                        aria-controls="DataTables_Table_1" rowspan="1" colspan="1"--}}
{{--                                                        aria-label="User: activate to sort column ascending"><span--}}
{{--                                                            class="sub-text">Date</span></th>--}}
{{--                                                    <th class="nk-tb-col sorting" tabindex="0"--}}
{{--                                                        aria-controls="DataTables_Table_1" rowspan="1" colspan="1"--}}
{{--                                                        aria-label="User: activate to sort column ascending"><span--}}
{{--                                                            class="sub-text">CODE</span></th>--}}
{{--                                                    <th class="nk-tb-col sorting" tabindex="0"--}}
{{--                                                        aria-controls="DataTables_Table_1" rowspan="1" colspan="1"--}}
{{--                                                        aria-label="User: activate to sort column ascending"><span--}}
{{--                                                            class="sub-text">SKU</span></th>--}}
{{--                                                    <th class="nk-tb-col sorting" tabindex="0"--}}
{{--                                                        aria-controls="DataTables_Table_1" rowspan="1" colspan="1"--}}
{{--                                                        aria-label="User: activate to sort column ascending"><span--}}
{{--                                                            class="sub-text">Name</span></th>--}}
{{--                                                    <th class="nk-tb-col sorting" tabindex="0"--}}
{{--                                                        aria-controls="DataTables_Table_1" rowspan="1" colspan="1"--}}
{{--                                                        aria-label="User: activate to sort column ascending"><span--}}
{{--                                                            class="sub-text">Size</span></th>--}}
{{--                                                    <th class="nk-tb-col sorting" tabindex="0"--}}
{{--                                                        aria-controls="DataTables_Table_1" rowspan="1" colspan="1"--}}
{{--                                                        aria-label="User: activate to sort column ascending"><span--}}
{{--                                                            class="sub-text">Price</span></th>--}}
{{--                                                    <th class="nk-tb-col sorting" tabindex="0"--}}
{{--                                                        aria-controls="DataTables_Table_1" rowspan="1" colspan="1"--}}
{{--                                                        aria-label="User: activate to sort column ascending"><span--}}
{{--                                                            class="sub-text">Qty</span></th>--}}
{{--                                                    <th class="nk-tb-col sorting" tabindex="0"--}}
{{--                                                        aria-controls="DataTables_Table_1" rowspan="1" colspan="1"--}}
{{--                                                        aria-label="User: activate to sort column ascending"><span--}}
{{--                                                            class="sub-text">Amount</span></th>--}}

{{--                                                </tr>--}}
{{--                                            </thead>--}}
{{--                                            <tbody>--}}
{{--                                                @foreach($sales as $key=>$sale)--}}
{{--                                                @foreach(unserialize($sale->sale) as $item_key=>$detail)--}}
{{--                                                <tr class="nk-tb-item odd" role="row">--}}

{{--                                                    <td class="nk-tb-col">--}}
{{--                                                        <div class="user-card">--}}

{{--                                                            <div class="user-info">--}}
{{--                                                                <span class="tb-lead">{{$sale->created_at}} <span--}}
{{--                                                                        class="dot dot-success d-md-none ml-1"></span></span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
{{--                                                    <td class="nk-tb-col">--}}
{{--                                                        <div class="user-card">--}}

{{--                                                            <div class="user-info">--}}
{{--                                                                <span class="tb-lead">{{$sale->txn_code}}</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
{{--                                                    <td class="nk-tb-col">--}}
{{--                                                        <div class="user-card">--}}

{{--                                                            <div class="user-info">--}}
{{--                                                                <span class="tb-lead">{{$detail['sku']}}</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
{{--                                                    <td class="nk-tb-col">--}}
{{--                                                        <div class="user-card">--}}

{{--                                                            <div class="user-info">--}}
{{--                                                                <span class="tb-lead">{{$detail['product_name']}}</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
{{--                                                    <td class="nk-tb-col">--}}
{{--                                                        <div class="user-card">--}}

{{--                                                            <div class="user-info">--}}
{{--                                                                <span class="tb-lead">{{$detail['size']}}</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
{{--                                                    <td class="nk-tb-col">--}}
{{--                                                        <div class="user-card">--}}

{{--                                                            <div class="user-info">--}}
{{--                                                                <span--}}
{{--                                                                    class="tb-lead">{{number_format($detail['price'],2)}}</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
{{--                                                    <td class="nk-tb-col">--}}
{{--                                                        <div class="user-card">--}}

{{--                                                            <div class="user-info">--}}
{{--                                                                <span class="tb-lead">{{$detail['quantity']}}</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
{{--                                                    <td class="nk-tb-col">--}}
{{--                                                        <div class="user-card">--}}

{{--                                                            <div class="user-info">--}}
{{--                                                                <span--}}
{{--                                                                    class="tb-lead">{{number_format(($detail['price']*$detail['quantity']),2)}}</span>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
{{--                                                </tr>--}}
{{--                                                @endforeach--}}
{{--                                                @endforeach--}}


{{--                                            </tbody>--}}
{{--                                        </table>--}}
{{--                                    </div>--}}
{{--                                    <div class="row align-items-center">--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


    <div class="modal" id="TransactionsSummaryModal" wire:ignore.self>>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mobtn" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary mobtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

