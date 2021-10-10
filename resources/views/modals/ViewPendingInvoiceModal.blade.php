<div class="modal" id="ViewPendingInvoiceModal" wire:ignore.self>>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="example-alert">
                    <div class="alert alert-primary alert-icon">
                         <strong>INVOICES NOT PAID</strong></div>
                </div>
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
                                        class="sub-text">BRANCH</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">INVOICE NO.</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">SUPPLIER</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">AMOUNT</span></th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $totalPending=0; ?>
                            @foreach($pendingInv as $id=>$invoice)
                                <?php $InvoiceTotal=0; ?>
                                @foreach(unserialize($invoice['order_data']) as $data)
                                    <?php $totalPending+=$data['cost']*$data['stock']; ?>
                                    <?php $InvoiceTotal+=$data['cost']*$data['stock']; ?>
                                @endforeach
                                <tr class="nk-tb-item odd" role="row">
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">Created: {{$invoice['created_at']}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                                <div class="form-note">Due: {{$invoice['due_on']}} <code>{{ \Carbon\Carbon::parse($invoice['due_on'])->diffForHumans() }}</code></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{\App\Models\Branch::find($invoice['branch_id'])->name}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{$invoice->invoice_id}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{\App\Models\Supplier::find($invoice->supplier_id)->supplier_code}} {{\App\Models\Supplier::find($invoice['supplier_id'])->name}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info text-right">
                                                <span class="tb-lead">{{number_format($InvoiceTotal,2)}}</span>
                                            </div>
                                        </div>
                                    </td>

                                </tr>

                            @endforeach

                            <tr class="nk-tb-item odd" role="row">
                                <td class="nk-tb-col" colspan="3">
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

                                        <div class="user-info text-right">
                                            <span class="tb-lead"><strong>{{number_format($totalPending,2)}}</strong><span class="dot dot-success d-md-none ml-1"></span></span>
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
