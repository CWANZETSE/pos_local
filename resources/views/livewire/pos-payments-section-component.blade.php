<div class="page-content" wire:ignore.self>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-body user_products_and_pay_card">
                    <div class="form-group">
                        <label>TOTAL</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button class="btn btn-primary   dropdown-toggle waves-effect waves-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">KSH</button>

                            </div>
                            <label class="form-control alert-primary" style="border: 2px solid lightgray;font-size: 30px;padding-bottom: 0;text-align: right;color: #f64b81;padding-right: 30px;background-color: #fff;">{{number_format($totalBill,2)}}</label>
                        </div>
                    </div>


                    <div style="position: absolute;bottom: 0;" class="mb-3 d-flex">

                        <form class="form-inline">
                            <div class="form-group mx-sm-3">
                                <select class="form-control" wire:model="hold_release_bill">
                                    <option value="">--Select Option--</option>
                                    <option value="HoldBill">Hold Bill</option>
                                    <option value="ReleaseBill">Release Bill</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary waves-effect waves-light mx-3" wire:click.prevent="showPaymentModal()">SUBMIT PAYMENT</button>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('modals.paymentsModal')

</div>