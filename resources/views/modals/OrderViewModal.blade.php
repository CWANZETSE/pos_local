<div class="modal" id="OrderViewModal" wire:ignore.self>>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div id="" class=" dt-bootstrap4 no-footer">

                    <div class=" my-3">
                        <table class="nk-tb-list nk-tb-ulist no-footer" data-auto-responsive="false" id="" role="grid"
                               aria-describedby="DataTables_Table_1_info">
                            <thead>
                            <tr class="nk-tb-item nk-tb-head" role="row">
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">DATE</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">SUPPLIER</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">BRANCH</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">PRODUCT</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">SIZE</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">PACKAGING</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">QUANTITY</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">UNIT COST</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">AMOUNT</span></th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $total=0; ?>
                            @if($orderData!=[])

                            @foreach(unserialize($orderData->order_data) as $key=> $detail)
                                <tr class="nk-tb-item odd" role="row">
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{$orderData->created_at}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{$orderData->supplier['name']}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{$orderData->branch['name']}}</span>
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
                                                <span class="tb-lead">{{$detail['size_name']}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{$detail['packaging']==="pack"?$detail['no_of_packs'].' '.$detail['packaging'].'(s) @ Ksh '.number_format($detail['cost_per_pack'],2).' with '.$detail['qty_in_pack'].' units per pack':'Single Unit(s)'}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{$detail['stock']}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead" style="text-align:right">{{number_format($detail['cost'],2)}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead" style="text-align:right">{{number_format(($detail['cost']*$detail['stock']),2)}}</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $total+=$detail['cost']*$detail['stock']; ?>

                            @endforeach

                            @endif

                            <tr class="nk-tb-item odd" role="row">
                                <td class="nk-tb-col" colspan="5">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead"><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead"><strong>CREATED BY</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead text-primary"><strong>{{$orderData?\App\Models\Admin::findOrFail($orderData['created_by'])->name:null}}</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead"><strong>TOTAL</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead" style="text-align:right"><strong>{{number_format($total,2)}}</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="nk-tb-item odd" role="row">
                                <td class="nk-tb-col" colspan="7">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead"><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead"><strong>ORDER STATUS</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead" style="text-align:right"><strong>@if($orderData) @if($orderData->status==0) PENDING @elseif($orderData->status==1) GOODS RECEIVED @else DECLINED @endif @endif</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
