
<div class="modal" id="InvoicePayModal" wire:ignore.self>>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                @if($errors->any())
                <div class="alert alert-danger alert-icon">
                    Payment error occured!
                </div>
                @endif
                <form autocomplete="off" style="padding: 5px;">
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">Invoice Number</label>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control @error('pay_invoice_id') is-invalid @enderror" id="pay_invoice_id" placeholder="Invoice ID" aria-describedby="name" wire:model="pay_invoice_id" style="border:1px solid #b7c2d0;" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">Supplier Name</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('pay_supplier_name') is-invalid @enderror" id="pay_supplier_name" placeholder="Supplier Name" aria-describedby="name" wire:model="pay_supplier_name" style="border:1px solid #b7c2d0;" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">Amount (Ksh)</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('pay_amount') is-invalid @enderror" id="pay_amount" aria-describedby="name" placeholder="Amount" wire:model="pay_amount" style="border:1px solid #b7c2d0;" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">Bank Name</label>
                                <div class="form-control-select">
                                    <select class="form-control @error('pay_bank_id') is-invalid @enderror" id="pay_bank_id" wire:model="pay_bank_id">
                                        <option value="">--Select Category--</option>
                                        @foreach($supplier_bank_data as $bank)
                                            <option value="{{$bank->id}}">{{$bank->bank_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">Account Number</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('pay_account_number') is-invalid @enderror" id="pay_account_number" placeholder="Account Number" aria-describedby="name" wire:model="pay_account_number" style="border:1px solid #b7c2d0;" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">Transaction Code</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('pay_bank_transaction_id') is-invalid @enderror" id="pay_bank_transaction_id" aria-describedby="name" placeholder="Bank Transaction ID" wire:model="pay_bank_transaction_id" style="border:1px solid #b7c2d0;">
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary mobtn" wire:click="SubmitInvoicePayment()">SUBMIT PAYMENT</button>
            </div>
        </div>
    </div>
</div>

