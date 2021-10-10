
<div class="modal fade" id="closeShiftModal" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="alert alert-warning icons-alert">
                    <p> <i class="icon-info"></i> Please ensure you have balanced before closing shift</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect waves-light"  wire:click.prevent="closeShift()">YES CLOSE SHIFT</button>
            </div>
        </div>
    </div>
</div>

