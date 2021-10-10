<div class="modal fade zoom" tabindex="-1" id="saleReversalModal" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    
                        
                        <div class="example-alert">
                            <div class="alert alert-warning alert-icon">
                                <em class="icon ni ni-alert-circle"></em><strong>Action cannot be undone!</strong> Please confirm reversal of the sale</div>
                        </div> 
                            
                        
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-lg btn-success" wire:click="reverseConfirmedSale()">Yes, Reverse</button>
                        
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>