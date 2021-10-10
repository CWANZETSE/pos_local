<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card user_products_and_pay_card">
                    <div class="card-body">
                        <div class="col-lg-12" style="text-align:center">
                            <div wire:loading>
                                <div class="form-group">
                                    <span class="text-danger">Please wait...</span>
                                </div>
                                <div class="spinner-border text-primary" role="status">
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-centered table-hover table-xl mb-0" id="recent-orders">
                                <thead>
                                    <tr>
                                        <th class="border-top-0">CODE</th>
                                        <th class="border-top-0">NAME</th>
                                        <th class="border-top-0">UNIT</th>
                                        <th class="border-top-0">QTY</th>
                                        <th class="border-top-0" style="text-align:right;">PRICE</th>
                                        <th class="border-top-0" style="text-align:right;">SUBTOTAL</th>
                                        <th class="border-top-0" style="text-align:right;">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sum_qty = 0; ?>
                                    @if(session('pos'))
                                    @foreach(session('pos') as $id=>$ProduAttributes)
                                    <tr>
                                        <td>{{$ProduAttributes['sku']}}</td>
                                        <td>{{$ProduAttributes['product_name']}}</td>
                                        <td>{{$ProduAttributes['size']}}</td>
                                        <td>{{$ProduAttributes['quantity']}}</td>
                                        <td style="text-align:right;">{{number_format($ProduAttributes['price'],2)}}</td>
                                        <td style="text-align:right;">{{number_format($ProduAttributes['price']*$ProduAttributes['quantity'],2)}}</td>
                                        <td style="text-align:right;"><i class="bx bx-trash text-danger" wire:click="ConfirmRemoveItemFromPOSModal({{$id}})"></i></td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
    </div> <!-- container-fluid -->
    @include('modals.ConfirmRemoveItemFromPOSModal')
</div>