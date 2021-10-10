
<div class="modal" id="AdminNewPurchaseOrderModal" wire:ignore.self>>
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-lg-12" style="text-align:center">
                    <div wire:loading>
                        <div class="form-group">
                            <span class="text-danger">Please wait...</span>
                        </div>
                        <div class="spinner-border text-primary" role="status">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">

                <div class="example-alert mb-5 {{$SuccessAddingProductToOrder?'':'d-none'}}">
                    <div class="alert alert-pro alert-success">
                        <div class="alert-text">
                            <h6>Success</h6>
                            <p>Product added to order successfully! You may complete order or add more products</p>
                        </div>
                    </div>
                </div>

                <form autocomplete="off" style="background:#f5f6fa;padding: 5px;">
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="default-01">Branch</label>
                                <div class="form-note">Store expecting goods</div>
                                <div class="form-control-select">
                                    <select class="form-control @error('branch_id') is-invalid @enderror" id="branch_id" wire:model="branch_id" style="border:1px solid #b7c2d0;">
                                        <option value="">--Select Branch--</option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->id}}">{{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="default-01">Supplier</label>
                                <div class="form-note">Must be same for each order</div>
                                <div class="form-control-select">
                                    <select class="form-control @error('supplier_id') is-invalid @enderror" id="supplier_id" wire:model="supplier_id" style="border:1px solid #b7c2d0;">
                                        <option value="">--Select Supplier--</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{$supplier->id}}">{{$supplier->supplier_code}} {{$supplier->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">SKU Code</label>
                                <div class="form-note">Scan product</div>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control @error('sku_code') is-invalid @enderror" placeholder="" wire:model="sku_code">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">Category</label>
                                <div class="form-note">From scanned product</div>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('category') is-invalid @enderror" placeholder="" wire:model="category" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">Product</label>
                                <div class="form-note">From scanned product</div>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('product') is-invalid @enderror" placeholder="" wire:model="product" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="full-name-1">Size</label>
                                <div class="form-note">From scanned product</div>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control @error('size') is-invalid @enderror" placeholder="" wire:model="size" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Package</label>
                            <div class="form-note">Product packaging</div>
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <select class="form-control form-control-lg" wire:model="packaging">
                                        <option value="single_units">Single Units</option>
                                        <option value="pack">Pack</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 {{$packaging==="pack"?'d-none':''}}">
                            <label class="form-label" for="default-01">Unit Cost Price</label>
                            <div class="form-note">Cost per single unit</div>
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control @error('cost') is-invalid @enderror" id="cost" placeholder="Ksh 100" aria-describedby="name" wire:model.lazy="cost" style="border:1px solid #b7c2d0;">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 {{$packaging==="single_units"?'d-none':''}}">
                            <label class="form-label" for="default-01">Single Pack Price</label>
                            <div class="form-note">Cost per pack</div>
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control @error('cost_per_pack') is-invalid @enderror" id="cost_per_pack" placeholder="Ksh 12,000 per pack" aria-describedby="name" wire:model="cost_per_pack" style="border:1px solid #b7c2d0;">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 {{$packaging==="single_units"?'d-none':''}}">
                            <label class="form-label" for="default-01">Qty in Pack</label>
                            <div class="form-note">No. of units in pack</div>
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control @error('qty_in_pack') is-invalid @enderror" id="qty_in_pack" placeholder="12 pieces in pack" aria-describedby="name" wire:model="qty_in_pack" style="border:1px solid #b7c2d0;">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 {{$packaging==="single_units"?'d-none':''}}">
                            <label class="form-label" for="default-01">No. of Packs</label>
                            <div class="form-note">Total number of packs purchased</div>
                            <div class="form-group">
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control @error('no_of_packs') is-invalid @enderror" id="no_of_packs" placeholder="5 Packs" aria-describedby="name" wire:model.lazy="no_of_packs" style="border:1px solid #b7c2d0;">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="form-label" for="default-01">Unit Retail Price</label>
                                <div class="form-note">Sell price per unit <span class="text-primary">{{$packaging==="pack"?'( Est cost Ksh '. number_format($estimated_cost,2).' )':''}}</span> </div>
                                <div class="form-control-wrap">
                                    <input type="{{$rrp>0?'text':'number'}}" class="form-control @error('rrp') is-invalid @enderror" id="rrp" placeholder="Ksh 150 per unit" aria-describedby="name" wire:model.lazy="rrp" style="border:1px solid #b7c2d0;" {{$priceAlreadySet?'disabled':''}}>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 {{$packaging==="pack"?'d-none':''}}">
                            <div class="form-group">
                                <label class="form-label" for="default-01">Stock Purchased</label>
                                <div class="form-note">Quantity purchased now</div>
                                <div class="form-control-wrap">
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" aria-describedby="name" placeholder="Stock" wire:model.lazy="stock" style="border:1px solid #b7c2d0;">
                                </div>
                            </div>
                        </div>


                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary mobtn" wire:click="AddProductToOrder()"><em class="icon ni ni-inbox-in mr-2"></em>  Add to Order</button>
            </div>
        </div>
    </div>
</div>

