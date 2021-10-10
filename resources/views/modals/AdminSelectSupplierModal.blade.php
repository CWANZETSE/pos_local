
<div class="modal fade" id="AdminSelectSupplierModal" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card">
                    <div class="card-inner" style="padding: 10px;">                        
                           
                            <div class="form-group">
                                <div class="form-control-select">
                                    <select class="form-control @error('supplier_id') is-invalid @enderror" id="supplier_id" wire:model="supplier_id" style="border:1px solid #b7c2d0;">
                                        <option value="">--Select Supplier--</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{$supplier->id}}">{{$supplier->supplier_code}} {{$supplier->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    
                        <div class="form-group mt-5">
                            <button type="button" class="btn btn-sm btn-success" wire:click="SelectSupplierFromModal()" {{$supplier_id==""?'disabled':''}}><em class="icon ni ni-check"></em> Select Supplier</button>
                        </div>
                        
                    </div>
                        

                </div>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

