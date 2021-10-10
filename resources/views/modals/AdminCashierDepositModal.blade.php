<div class="modal fade zoom" tabindex="-1" id="adminCashierDepositModal" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card">
                    <div class="card-inner">

                            <form action="#" class="has-validation-callback">
                                <div class="col-12">
                                    <div class="alert alert-icon alert-gray" role="alert">
                                        <em class="icon ni ni-alert-circle"></em>
                                        Approval or Decline Cannot be Reversed
                                    </div>
                                    @if($errorUpdating)
                                        <div class="example-alert mb-3">
                                            <div class="alert alert-danger">
                                                There was an error. Decisioning failed! </div>
                                        </div>
                                    @endif
                                    <div class="preview-block">
                                        <span class="preview-title overline-title">Decision</span>
                                        <div class="form-control-wrap ">
                                            <div class="form-control-select">
                                                <select class="form-control" id="default-06" wire:model="status">
                                                    <option value="">--Select Decision--</option>
                                                    <option value="{{\App\Models\Declarations::IS_APPROVED}}">Approve</option>
                                                    @if(!$ifFloat)
                                                        <option value="{{\App\Models\Declarations::IS_REJECTED}}">Reject</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    <div class="preview-block">
                                        <span class="preview-title overline-title">Comments</span>
                                        <div class="form-control-wrap ">
                                            <div class="form-control-select">
                                                <select class="form-control" id="default-06" wire:model="comments">
                                                    <option value="">--Select Comment--</option>
                                                        @if($status==\App\Models\Declarations::IS_APPROVED)
                                                            <option value="Cash Confirmed">Cash Confimed</option>
                                                        @elseif($status==\App\Models\Declarations::IS_REJECTED)
                                                            <option value="Cash Not Confirmed">Cash Not Confimed</option>
                                                            <option value="Wrong Currency">Wrong Currency</option>
                                                            <option value="Transaction Voided">Transaction Voided</option>
                                                            <option value="Fake Currency">Fake Currency</option>
                                                            <option value="Excess Cash">Excess Cash</option>
                                                            <option value="Unpproved Expense">Unapproved Expense</option>
                                                        @endif

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row gy-4 pt-10">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <a wire:click="DecisionOnDeposit" class="btn btn-secondary text-white">Submit</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
