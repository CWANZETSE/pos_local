<div class="modal" id="ViewPendingOrdersModal" wire:ignore.self>>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="example-alert">
                    <div class="alert alert-primary alert-icon">
                        <strong>PURCHASE ORDERS NOT DELIVERED</strong></div>
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
                                        class="sub-text">ORDER NO.</span></th>
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
                            @foreach($pendingOrders as $id=>$order)
                                <tr class="nk-tb-item odd" role="row">
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{$order['created_at']}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{\App\Models\Branch::find($order['branch_id'])->name}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{$order['order_id']}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info">
                                                <span class="tb-lead">{{\App\Models\Supplier::find($order['supplier_id'])->supplier_code}} {{\App\Models\Supplier::find($order['supplier_id'])->name}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="nk-tb-col">
                                        <div class="user-card">

                                            <div class="user-info text-right">
                                                <span class="tb-lead">{{number_format($order['order_total'],2)}}</span>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                                <?php $totalPending+=$order['order_total']; ?>

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
