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
            @if($errors->any())
                <div class="example-alert mb-3">
                    <div class="alert alert-danger alert-icon">
                        <em class="icon ni ni-alert-circle"></em> Please fill all required fields to generate report </div>
                </div>
            @endif
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <span class="preview-title-lg overline-title">stock position</span>
                        <div class="nk-block-des text-soft">

                                            </div>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em
                                    class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">

                                    <li>
                                        <div class="form-control-wrap focused">
                                            <div class="form-control-select">
                                                <select class="form-control" id="search_type" wire:model="search_type">
                                                    <option value="filter">By Filter</option>
                                                    <option value="code">By Code</option>

                                                </select>
                                                <label class="form-label-outlined" for="branch">Search</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="{{$viewFilters==true?'d-none':''}}">
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="default-04"
                                                   placeholder="Enter SKU Code" wire:model="searchCode">
                                        </div>
                                    </li>

                                    <li class="{{$viewFilters==false?'d-none':''}}">
                                        <div class="form-control-wrap focused">
                                            <div class="form-control-select">
                                                <select class="form-control" id="branch" wire:model="branch_id.lazy">
                                                    <option value="">--Select--</option>
                                                    @foreach($branches as $branch)
                                                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                                                    @endforeach

                                                </select>
                                                <label class="form-label-outlined" for="branch">Branch</label>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="{{$viewFilters==false?'d-none':''}}">
                                        <div class="form-control-wrap focused">
                                            <div class="form-control-select">
                                                <select class="form-control" id="branch" wire:model="reorder_level">
                                                    <option value="">--Select Reorder--</option>
                                                    <option value="all">All States</option>
                                                    <option value=">">Above Reorder</option>
                                                    <option value="<">Below Reorder</option>
                                                </select>
                                                <label class="form-label-outlined" for="branch">Reorder Level</label>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="{{$reportReady?'':'d-none'}}">
                                        <a href="#" class="btn btn-secondary {{$viewFilters==false?'d-none':''}}" wire:click.prevent="downloadPDF"><em class="icon ni ni-download text-light"></em> PDF <div class="ml-3" wire:loading>
                                                @include('loaders.loader6')
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div>
            <div id="" class=" dt-bootstrap4 no-footer">

                <div class=" my-3">
                    <table class="nk-tb-list nk-tb-ulist no-footer" data-auto-responsive="false" id="" role="grid"
                        aria-describedby="DataTables_Table_1_info">
                        <thead>
                            <tr class="nk-tb-item nk-tb-head" role="row">
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">#</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">SKU</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Product</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Size</span></th>

                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Price</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Reorder Level</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Stock</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Status</span></th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($products as $key=>$product)
                            <tr class="nk-tb-item odd {{$loop->odd?'bg-light':''}}" role="row">

                                <td class="nk-tb-col">
                                    <div class="user-card">
                                        <div class="user-info">
                                            <span class="tb-lead">{{$products->firstItem()+$key}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$product['sku']}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$product['product']['name']}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$product['size']}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{number_format($product['price'],2)}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{\App\Models\Size::find($product['size_id'])['reorder_level']}}</span>
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
                                            <span class="tb-lead"><span class="badge badge-pill {{$product['stock']<\App\Models\Size::find($product['size_id'])['reorder_level']?'badge-danger':'badge-success'}}">{{$product['stock']<\App\Models\Size::find($product['size_id'])['reorder_level']?'low':'ok'}}</span></span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
                <div class="row align-items-center">
                    @if($reorder_level =="all")
                        @if(is_array($products)) @else  {{ $products->links('pagination.admin') }} @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
