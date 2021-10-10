<div class="modal" id="InvoiceViewModal" wire:ignore.self>>
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
                                        class="sub-text" style="text-align: right">UNIT COST</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text" style="text-align: right">AMOUNT</span></th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $total=0; ?>
                                @foreach($InvoiceData as $id=>$invoice)
                                    @foreach(unserialize($invoice->order_data) as $id=>$data)
                                    <tr class="nk-tb-item odd" role="row">
                                        <td class="nk-tb-col">
                                            <div class="user-card">

                                                <div class="user-info">
                                                    <span class="tb-lead">{{$invoice->created_at}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            <div class="user-card">

                                                <div class="user-info">
                                                    <span class="tb-lead">{{$invoice->supplier->name}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            <div class="user-card">

                                                <div class="user-info">
                                                    <span class="tb-lead">{{$invoice->branch->name}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            <div class="user-card">

                                                <div class="user-info">
                                                    <span class="tb-lead">{{$data['product_name']}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            <div class="user-card">

                                                <div class="user-info">
                                                    <span class="tb-lead">{{$data['size_name']}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            <div class="user-card">

                                                <div class="user-info">
                                                    <span class="tb-lead">{{$data['packaging']==="pack"?$data['no_of_packs'].' '.$data['packaging'].'(s) @ Ksh '.number_format($data['cost_per_pack'],2).' with '.$data['qty_in_pack'].' units per pack':'Single Unit(s)'}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            <div class="user-card">

                                                <div class="user-info">
                                                    <span class="tb-lead">{{$data['stock']}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            <div class="user-card">

                                                <div class="user-info">
                                                    <span class="tb-lead" style="text-align:right">{{number_format($data['cost'],2)}}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            <div class="user-card">

                                                <div class="user-info">
                                                    <span class="tb-lead" style="text-align:right">{{number_format($data['cost']*$data['stock'],2)}}</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $total+=$data['cost']*$data['stock']; ?>

                                    @endforeach

                                @endforeach

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
                                            <span class="tb-lead"><strong>PAYMENT</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead" style="text-align:right"><strong>@if($SingleInvoice){{$SingleInvoice['payment_status']==1?'PAID':'PENDING'}}@endif</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @if($SingleInvoice)
                                @if($SingleInvoice['payment_status']==1)
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
                                            <span class="tb-lead"><strong>INVOICE NUMBER</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead" style="text-align:right"><strong>@if($SingleInvoice){{$SingleInvoice['invoice_id']}}@endif</strong><span class="dot dot-success d-md-none ml-1"></span></span>
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
                                            <span class="tb-lead"><strong>PAYMENT ID</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead" style="text-align:right"><strong>@if($SingleInvoice){{$SingleInvoice['payment_id']}}@endif</strong><span class="dot dot-success d-md-none ml-1"></span></span>
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
                                            <span class="tb-lead"><strong>BANK NAME</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead" style="text-align:right"><strong>@if($SingleInvoice){{$SingleInvoice['bank_name']}}@endif</strong><span class="dot dot-success d-md-none ml-1"></span></span>
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
                                            <span class="tb-lead"><strong>ACCOUNT NUMBER</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead" style="text-align:right"><strong>@if($SingleInvoice){{$SingleInvoice['account_number']}}@endif</strong><span class="dot dot-success d-md-none ml-1"></span></span>
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
                                            <span class="tb-lead"><strong>BANK TRANSACTION ID</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead" style="text-align:right"><strong>@if($SingleInvoice){{$SingleInvoice['bank_transaction_id']}}@endif</strong><span class="dot dot-success d-md-none ml-1"></span></span>
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
                                            <span class="tb-lead"><strong>DATETIME PAID</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead" style="text-align:right"><strong>@if($SingleInvoice){{$SingleInvoice['paid_on']}}@endif</strong><span class="dot dot-success d-md-none ml-1"></span></span>
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
                                            <span class="tb-lead"><strong>COMPLETED BY</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead" style="text-align:right"><strong>@if($SingleInvoice){{$SingleInvoice['paid_by']!=null?\App\Models\Admin::find($SingleInvoice['paid_by'])->name:''}}@endif</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endif
                                @endif

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
