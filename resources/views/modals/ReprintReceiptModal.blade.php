<div class="modal fade zoom" tabindex="-1" id="ReprintReceiptModal" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12">
                        <div wire:loading>
                            <p class="text-danger">Contacting printer...Please wait</p>
                        </div>
                        <div class="table-responsive">
                            <table class="table  invoice-detail-table">
                                <thead>
                                <tr class="thead-default">
                                    <th width ="auto">Txn Date</th>
                                    <th>Sale No.</th>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(!count($sales_allowed_reprint))
                                    <tr>
                                        <td width ="auto" colspan="5">
                                            <div class="alert alert-danger">No Receipts for Reprint found</div>
                                        </td>
                                    </tr>
                                    @else

                                @foreach($sales_allowed_reprint as $sale)
                                    <tr>
                                        <td width ="auto">
                                            <p>{{$sale['created_at']}}</p>
                                        </td>
                                        <td>{{$sale['txn_code']}}</td>
                                        <td>{{\App\Models\User::find($sale['user_id'])->username}}</td>
                                        <td>{{number_format($sale['total'],2)}}</td>
                                        <td><a href="#"><i class="ti-printer text-primary" style="size:15px;" wire:click="ReprintReceipt({{$sale['id']}})"></i></a> <a href="#" class="mx-10"><i class="icon-close text-danger" wire:click="CancelReprintReceipt({{$sale['id']}})"></i></a></td>
                                    </tr>

                                @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
