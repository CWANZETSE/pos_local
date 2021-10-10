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
                        <span class="preview-title-lg overline-title">stock purchase</span>
                        <div class="nk-block-des text-soft">

                                            </div>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em
                                    class="icon ni ni-more-v"></em></a>

                        </div>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div>
            <div id="" class=" dt-bootstrap4 no-footer">

                <div class=" my-3">
                    <div class="card">
                        <div class="card-inner">
                            @if($errors->any())
                            <div class="alert alert-danger alert-icon">
                                There is some technical issues.
                            </div>
                            @endif

                            <form autocomplete="off" style="background:#f5f6fa;padding: 5px;">
                                <div class="row g-4">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="default-01">Supplier</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                    <span class="overline-title" wire:click="ShowSupplierSelectModal()"><em class="icon ni ni-plus-round-fill text-primary" style="font-size:25px;"></em></span>
                                                </div>
                                                <input type="text" class="form-control" id="default-05" placeholder="Supplier" style="border:1px solid #b7c2d0;" wire:model="supplier_name" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="default-01">Branch</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                    <span class="overline-title" wire:click="ShowBranchSelectModal()"><em class="icon ni ni-plus-round-fill text-primary" style="font-size:25px;"></em></span>
                                                </div>
                                                <input type="text" class="form-control" id="default-05" placeholder="Branch" style="border:1px solid #b7c2d0;" wire:model="branch_name" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="default-01">Category</label>
                                            <div class="form-control-select">
                                                <select class="form-control @error('supplier_id') is-invalid @enderror" id="supplier_id" wire:model="category_id" style="border:1px solid #b7c2d0;">
                                                    <option value="">--Select Category--</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="default-01">Product</label>
                                            <div class="form-control-select">
                                                <select class="form-control @error('supplier_id') is-invalid @enderror" id="supplier_id" wire:model="product_id" style="border:1px solid #b7c2d0;">
                                                    <option value="">--Select Product--</option>
                                                    @foreach($products as $product)
                                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="default-01">Size</label>
                                            <div class="form-control-select">
                                                <select class="form-control @error('supplier_id') is-invalid @enderror" id="supplier_id" wire:model="size_id" style="border:1px solid #b7c2d0;">
                                                    <option value="">--Select Size--</option>
                                                    @foreach($sizes as $size)
                                                        <option value="{{$size->id}}">{{$size->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label" for="default-01">Unit Cost Price</label>
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control @error('cost') is-invalid @enderror" id="cost" placeholder="Unit Cost" aria-describedby="name" wire:model.lazy="cost" style="border:1px solid #b7c2d0;">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="default-01">Unit Retail Price</label>
                                            <div class="form-control-wrap">
                                                <input type="{{$rrp>0?'text':'number'}}" class="form-control @error('rrp') is-invalid @enderror" id="rrp" placeholder="Unit RRP" aria-describedby="name" wire:model.lazy="rrp" style="border:1px solid #b7c2d0;" {{$rrp>0?'disabled':''}}>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-label" for="default-01">Stock Purchased</label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" aria-describedby="name" placeholder="Stock" wire:model.lazy="stock" style="border:1px solid #b7c2d0;">
                                            </div>
                                        </div>
                                    </div>


                                </div>

                            </form>
                                <div class="card mt-5" style="background:#f5f6fa">
                                    <div class="card-inner">
                                        <div class="nk-block-between-md g-3">
                                            <div class="g">
                                                <div>
                                                    <button type="button" class="btn btn-sm btn-danger" wire:click.prevent="CancelInvoiceCreation" {{$canCompleteInvoice?'':'disabled'}}><em class="icon ni ni-cross-round" style="font-size:20px;"></em> Cancel Invoice</button>
                                                </div>
                                            </div>
                                            <div class="g">
                                                <div class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3">
                                                    <div>
                                                        <button type="button" class="btn btn-sm btn-primary" wire:click.prevent="AddProductToInvoice()"><em class="icon ni ni-plus-round" style="font-size:20px;"></em> Add Product</button>
                                                    </div>
                                                    <div>
                                                        <button type="button" class="btn btn-sm btn-success" wire:click.prevent="CompleteCreateInvoice()" {{$canCompleteInvoice?'':'disabled'}}><em class="icon ni ni-check-round" style="font-size:20px;"></em> Complete Invoice</button>
                                                    </div>
                                                </div>
                                            </div><!-- .pagination-goto -->
                                        </div><!-- .nk-block-between -->
                                    </div><!-- .card-inner -->
                                </div>

                            <div id="" class=" dt-bootstrap4 no-footer">

                                <div class=" my-3">
                                    <table class="nk-tb-list nk-tb-ulist no-footer" data-auto-responsive="false" id="" role="grid"
                                           aria-describedby="DataTables_Table_1_info">
                                        <thead>
                                        <tr class="nk-tb-item nk-tb-head" role="row">
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Supplier</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Branch</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Product</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Size</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Quantity</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Cost</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Amount</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Remove</span></th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $total=0; ?>
                                        @if(session('purchase_session'))
                                            @foreach(session('purchase_session') as $id=>$product)
                                            <tr class="nk-tb-item odd {{$loop->odd?'bg-light':''}}" role="row">
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$product['supplier_name']}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$product['branch_name']}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$product['product_name']}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$product['size_name']}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$product['stock']}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead" style="text-align:right">{{number_format($product['cost'],2)}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead" style="text-align:right">{{number_format($product['cost']*$product['stock'],2)}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <em class="icon ni ni-minus-round text-danger" style="font-size:20px" wire:click="RemoveProduct({{$id}})"></em>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php $total+=$product['cost']*$product['stock']; ?>

                                            @endforeach
                                        @endif
                                        <tr class="nk-tb-item odd" role="row">
                                            <th class="nk-tb-col" colspan="5">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><strong>SUBTOTAL</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead" style="text-align:right"><strong>{{number_format($total,2)}}</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr class="nk-tb-item odd" role="row">
                                            <th class="nk-tb-col" colspan="5">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><strong>TAX</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead" style="text-align:right"><strong>0.00</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr class="nk-tb-item odd" role="row">
                                            <th class="nk-tb-col" colspan="5">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><strong>TOTAL</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead" style="text-align:right"><strong>{{number_format($total,2)}}</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </th>
                                            <th class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    @include('modals.AdminSelectSupplierModal')
    @include('modals.AdminSelectBranchModal')

</div>
