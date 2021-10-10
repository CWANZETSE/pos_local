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
            @if($error)
            <div class="example-alert pb-5">
                <div class="alert alert-danger alert-icon">
                    <em class="icon ni ni-check-circle"></em> <strong>Error!</strong> Failed to Create New product!
                </div>
            </div>
            @endif
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <span class="preview-title-lg overline-title">products</span>
                        <div class="nk-block-des text-soft">
                                                <p>Total of {{number_format($count->count())}} records found.</p>
                                            </div>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em
                                    class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li>
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-right">
                                                <em class="icon ni ni-search"></em>
                                            </div>
                                            <input type="text" class="form-control" id="default-04"
                                                placeholder="Quick Search" wire:model="search">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-control-wrap ">
                                            <div class="form-control-select">
                                                <select class="form-control" wire:model="sorting">
                                                    <option value="default">Default</option>
                                                    <option value="active">Active</option>
                                                    <option value="disabled">Disabled</option>
                                                </select>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-control-wrap ">
                                            <div class="form-control-select">
                                                <select class="form-control" wire:model="pagesize">
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="15">15</option>
                                                    <option value="20">20</option>
                                                </select>
                                            </div>
                                        </div>
                                    </li>
                                    @can('allow_create')
                                    <li class="nk-block-tools-opt">
                                        <button type="button" class="btn btn-primary"
                                            wire:click="showCreateProductModal"><em
                                                class="icon ni ni-plus"></em><span>Add product</span></button>
                                    </li>
                                    @endcan
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
                                        class="sub-text">Parent Category</span></th>
                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                        class="sub-text">Product Name</span></th>
                                <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="Verified: activate to sort column ascending">
                                    <span class="sub-text">Sizes</span></th>
                                <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                    rowspan="1" colspan="1" aria-label="Verified: activate to sort column ascending">
                                    <span class="sub-text">Status</span></th>
                                @can('allow_create')
                                <th class="nk-tb-col nk-tb-col-tools text-right sorting" tabindex="0"
                                    aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="
                                                            : activate to sort column ascending">
                                </th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $key=>$product)
                            <tr class="nk-tb-item odd {{$loop->odd?'bg-light':''}}" role="row">

                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$products->firstItem()+$key}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$product->category->name}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">

                                        <div class="user-info">
                                            <span class="tb-lead">{{$product->name}}</span>
                                        </div>
                                    </div>
                                </td>


                                <td class="nk-tb-col tb-col-lg">
                                    <div class="user-info">
                                        <span class="badge badge-outline-secondary">{{$product->sizes->count()}}</span>
                                        </div>
                                </td>
                                <td class="nk-tb-col tb-col-lg" data-order="Email Verified - Kyc Unverified">
                                    <em
                                        class="icon {{$product->status?'text-success':'text-danger'}} {{$product->status?'ni ni-check-circle':'ni ni-alert-circle'}}"></em>
                                    <span
                                        class="tb-status {{$product->status?'text-success':'text-danger'}}">{{$product->status?'Active':'Deactivated'}}</span>
                                </td>
                                @can('allow_create')
                                <td class="nk-tb-col nk-tb-col-tools">
                                    <ul class="nk-tb-actions gx-1">

                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger"
                                                    data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a><span>{{$product->name}} product</span></a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li><a data-toggle="modal"
                                                                wire:click="changeToUpdatingMode({{$product->id}})"><em
                                                                    class="icon ni ni-edit"></em><span>Update
                                                                </span></a></li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                                @endcan
                            </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="row align-items-center">
                    {{ $products->links('pagination.admin') }}
                </div>
            </div>
        </div>
    </div>
    @include('modals.addEditProductModal')
</div>
