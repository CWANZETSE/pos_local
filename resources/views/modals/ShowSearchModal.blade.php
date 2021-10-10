<div class="modal fade zoom" tabindex="-1" id="ShowSearchModal" wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <div class="row">
                    <div class="col-xl-12">

                        <div class="form-group">
                            <label for="simpleinput">SEARCH PRODUCT</label>
                            <input type="text" id="simpleinput" wire:model="searchProduct" class="form-control col-xs-4 col-md-12 col-lg-12 col-xl-12" onkeyup="ifEmpty()">
                        </div>

                    </div> <!-- end col -->

                </div>

            </div>
            <div class="modal-body">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-xl-12" style="text-align:center">
                                <div wire:loading>
                                    <div class="form-group">
                                        <span class="text-danger">Please wait...</span>
                                    </div>
                                    <div class="spinner-border text-primary" role="status">
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover table-centered table-nowrap mb-0">
                                    <tbody>

                                        <thead>
                                            <tr>
                                                <th class="border-top-0">#</th>
                                                <th class="border-top-0">Code</th>
                                                <th class="border-top-0">Name</th>
                                                <th class="border-top-0">Size</th>
                                                <th class="border-top-0" style="text-align: right;">Price (Ksh)</th>
                                                <th class="border-top-0">Stock</th>
                                            </tr>
                                        </thead>

                                        @foreach($selectedAttributes as $key => $attribute)

                                        <tr wire:click.prevent="selectAttribute({{$attribute['id']}},{{$attribute['stock']}})">
                                            <td>
                                                <h5 class="font-size-15 mb-1 font-weight-normal">{{$key+1}} </h5>
                                            </td>
                                            <td>
                                                <h5 class="font-size-15 mb-1 font-weight-normal">{{$attribute['sku']}} </h5>
                                            </td>
                                            <td>
                                                <h5 class="font-size-15 mb-1 font-weight-normal">{{$attribute->product?$attribute->product->name:''}}</h5>
                                            </td>
                                            <td>
                                                <h5 class="font-size-15 mb-1 font-weight-normal">{{$attribute['size']}}</h5>
                                            </td>
                                            <td style="text-align: right;">
                                                <h5 class="font-size-15 mb-1 font-weight-normal">{{number_format($attribute['price'],2)}}
                                                </h5>
                                            </td>
                                            <td>
                                                <h5 class="font-size-15 mb-1 font-weight-normal">{{$attribute['stock']}}
                                                </h5>
                                            </td>
                                        </tr>

                                        @endforeach


                                    </tbody>
                                </table>
                            </div>

                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div>
            </div>
        </div>
    </div>
</div>