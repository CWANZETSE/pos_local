<div class="modal fade zoom" tabindex="-1" id="addEditSizeModal" wire:ignore.self>
        <div class="modal-dialog" role="document">
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
                    <h5 class="modal-title mb-4">{{$updatingMode?'Update Size':'New Size'}}</h5>
                    <div class="card">
                        <div class="card-inner">

                            <form autocomplete="off" wire:submit.prevent="{{$updatingMode ? 'updateSize':'AddSize'}}">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Category</label>
                                            <div class="form-control-select">
                                                <select class="form-control @error('category_id') is-invalid @enderror" id="default-06" wire:model="category_id" {{$updatingMode?'disabled':''}}>
                                                    <option value="">--Select Category--</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                        <label class="form-label" for="full-name-1">Product</label>
                                        <div class="form-control-select">
                                            <select class="form-control @error('product_id') is-invalid @enderror" id="default-06" wire:model="state.product_id" {{$updatingMode?'disabled':''}}>
                                                <option value="">--Select Product--</option>
                                                @foreach($products as $product)
                                                <option value="{{$product->id}}">{{$product->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">SKU CODE</label>
                                            <div class="form-control-wrap">
                                                <input type="number" placeholder="1235241784" class="form-control @error('sku') is-invalid @enderror" id="sku" aria-describedby="name" wire:model.lazy="state.sku">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Size & Unit</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="name" placeholder="200 g" wire:model.lazy="state.name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Taxable</label>
                                            <div class="form-control-select">
                                                <select class="form-control @error('taxable') is-invalid @enderror" id="default-06" wire:model.lazy="taxable">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Tax</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('tax_percentage') is-invalid @enderror" id="name" aria-describedby="name" placeholder="200 g" wire:model.lazy="tax_percentage" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Reorder Level</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('reorder_level') is-invalid @enderror" id="name" aria-describedby="name" placeholder="0" wire:model.lazy="state.reorder_level">
                                            </div>
                                        </div>
                                    </div>



                                </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">

                        <button type="submit" class="btn btn-lg btn-primary">Save Information</button>

                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
