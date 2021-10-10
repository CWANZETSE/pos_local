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
                        <span class="preview-title-lg overline-title">new purchase order</span>
                    </div><!-- .nk-block-head-content -->

                </div><!-- .nk-block-between -->
            </div>
            <div id="" class=" dt-bootstrap4 no-footer">

                <div class="">
                            <div class="card">
                                <div class="card-inner">
                                    <div class="nk-block-between-md g-3">
                                        <div class="g">
                                            <div>
                                                <button type="button" class="btn btn-sm btn-warning" wire:click.prevent="NewOrderModal()"><em class="icon ni ni-plus" style="font-size:20px;"></em> New Purchase Order</button>
                                            </div>
                                        </div>
                                        <div class="g">
                                            <div class="pagination-goto d-flex justify-content-center justify-content-md-start gx-3">
                                                <div>
                                                    <button type="button" class="btn btn-sm btn-danger" wire:click.prevent="CancelOrderCreation" {{$canCompleteOrder?'':'disabled'}}> Cancel Order</button>
                                                </div>
                                                <div>
                                                    <button type="button" class="btn btn-sm btn-success" wire:click.prevent="CompleteCreateOrder()" {{$canCompleteOrder?'':'disabled'}}> Complete Order</button>
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
                                                    class="sub-text">Packaging</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Qty Units</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Cost Per Unit (Ksh)</span></th>
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
                                                                <span class="tb-lead">{{$product['packaging']==="pack"?$product['no_of_packs'].' '.$product['packaging'].'(s) @ Ksh '.number_format($product['cost_per_pack'],2).' with '.$product['qty_in_pack'].' units per pack':'Single Unit(s)'}}</span>
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
                                            <td class="nk-tb-col" colspan="6">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><strong>SUBTOTAL</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead" style="text-align:right"><strong>{{number_format($total,2)}}</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="nk-tb-item odd" role="row">
                                            <td class="nk-tb-col" colspan="6">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><strong>TAX</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead" style="text-align:right"><strong>0.00</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="nk-tb-item odd" role="row">
                                            <td class="nk-tb-col" colspan="6">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><strong>TOTAL</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead" style="text-align:right"><strong>{{number_format($total,2)}}</strong><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead"><span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>

    </div>

    @include('modals.AdminSelectSupplierModal')
    @include('modals.AdminSelectBranchModal')
    @include('modals.AdminNewPurchaseOrderModal')
    @include('modals.SuccessAddingProductToOrderModal')

</div>
