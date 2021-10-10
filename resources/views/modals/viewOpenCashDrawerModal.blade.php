
    <div class="modal fade" id="viewOpenCashDrawerModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <label>Confirm Password</label>
                    <div class="form-input">
                        <input type="password" class="form-control" placeholder="" wire:model="confirmPassword">
                    </div>
                </div>
                <div class="modal-footer">
                    <small class="text-danger" wire:loading>Checking printer connection...</small>
                    <button type="button" class="btn btn-primary waves-effect waves-light"  wire:click.prevent="confirmPasswordForTill()">SUBMIT</button>
                </div>
            </div>
        </div>
    </div>

