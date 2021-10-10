<div class="nk-content ">

    <div class="card card-preview">
        <div class="card-inner">
            <div class="col-lg-12" style="text-align:center">
                <div wire:loading>
                    <div class="form-group">
                        <span class="text-danger">Please wait...</span>
                    </div>
                    <div class="spinner-border text-primary" role="status">
                    </div>
                </div>
            </div>
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <span class="preview-title-lg overline-title">price management</span>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em
                                    class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">

                                    <li class="nk-block-tools-opt {{$productExists?'':'d-none'}}">
                                        <button type="button" class="btn btn-primary"
                                                wire:click="updatePrice"><span>Update Price</span></button>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div>
            <div autocomplete="off">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label" for="full-name-1">Branch</label>
                            <div class="form-note">Store with product</div>
                            <div class="form-control-select">
                                <select class="form-control @error('branch_id') is-invalid @enderror" id="branch_id" wire:model="branch_id">
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

                </div>

                <div class="row g-4">
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
                        <div class="form-group">
                            <label class="form-label" for="full-name-1">Cost Price</label>
                            <div class="form-note">Cost from supplier</div>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control @error('buying_price') is-invalid @enderror" id="buying_price" aria-describedby="name" wire:model.lazy="buying_price" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label" for="full-name-1">Current Retail Price</label>
                            <div class="form-note">Store selling price</div>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control @error('current_price') is-invalid @enderror" id="current_price" aria-describedby="name" wire:model.lazy="current_price" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label class="form-label" for="full-name-1">New Retail Price</label>
                            <div class="form-note">Store new selling price</div>
                            <div class="form-control-wrap">
                                <input type="number" class="form-control @error('new_price') is-invalid @enderror" id="new_price" aria-describedby="name" wire:model="new_price">
                            </div>
                        </div>
                    </div>


                </div>

            </div>

        </div>
    </div>

</div>

