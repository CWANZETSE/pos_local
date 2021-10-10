
<div class="modal fade" id="OrderActionModal" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card">
                    <div class="card-inner" style="padding: 10px;">

                        <div class="form-group">
                            <div class="example-alert">
                                <div class="alert alert-primary alert-icon">
                                    <em class="icon ni ni-alert-circle"></em>Decision cannot be undone. If declined in error, you may place a new Purchase Order</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-control-select">
                                <select class="form-control @error('decision_id') is-invalid @enderror" id="decision_id" wire:model="decision_id" style="border:1px solid #b7c2d0;">
                                    <option value="">--Select Action--</option>
                                    <option value="1">Receive Goods</option>
                                    <option value="2">Decline Order</option>
                                </select>
                            </div>
                        </div>



                        <div class="form-group mt-5">
                            <button type="button" class="btn btn-sm btn-success" wire:click="SelectOrderDecisionFromModal()" {{$decision_id==""?'disabled':''}}> Submit Decision</button>
                        </div>

                    </div>


                </div>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

