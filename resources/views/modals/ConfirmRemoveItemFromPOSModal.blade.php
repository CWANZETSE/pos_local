
<div class="modal fade" id="ConfirmRemoveItemFromPOSModal" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-xl-12">
                        <div class="alert alert-warning">
                            <i class="icon-info"></i> Do you wish to remove item from basket?
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" wire:click="removeItemFromPos">Yes Remove</button>
            </div>
        </div>
    </div>
</div>

