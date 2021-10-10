<div class="modal fade zoom" tabindex="-1" id="purchaseCancelModal" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    
                        
                        <div class="example-alert">
                            <div class="alert alert-warning alert-icon">
                                <em class="icon ni ni-alert-circle"></em><strong>Action cannot be undone!</strong> Please confirm purchase cancellation</div>
                        </div> 
                            
                        
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-lg btn-success" wire:click="cancelConfirmedPurchase()">Yes, Cancel</button>
                        
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>