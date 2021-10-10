<div class="modal fade zoom" tabindex="-1" id="discountModal" wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card">
                    <div class="card-inner">
                        <div class="nk-content ">
                                    <div class="nk-block-head nk-block-head-sm">
                                        <div class="nk-block-between">
                                            <div class="nk-block-head-content">
                                                <div class="toggle-wrap nk-block-tools-toggle">
                                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em
                                                            class="icon ni ni-more-v"></em></a>
                                                    <div class="toggle-expand-content" data-content="pageMenu">
                                                        <ul class="nk-block-tools g-3">
                                                            <li>
                                                                <div class="form-control-wrap ">
                                                                    <div class="form-control-select">
                                                                        <select class="form-control" wire:model="report_branch_id">
                                                                            <option value="">--Select Branch--</option>
                                                                            @foreach($branches as $branch)
                                                                                <option value="{{$branch->id}}">{{$branch->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="form-control-wrap ">
                                                                    <div class="form-control-select">
                                                                        <select class="form-control" wire:model="report_status">
                                                                            <option value="">--Select Status--</option>
                                                                            <option value="active">Active</option>
                                                                            <option value="expired">Expired</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="{{$report_status=='expired'?'':'d-none'}}">

                                                                <div class="form-control-wrap focused" id="startReportDateDiv" data-reportstartdate="@this">
                                                                    <div class="form-icon form-icon-right">
                                                                        <em class="icon ni ni-calendar-alt"></em>
                                                                    </div>
                                                                    <input type="text" class="form-control form-control-outlined date-picker" id="reportDateFrom" wire:model.lazy="report_date_from" required>
                                                                    <label class="form-label-outlined" for="outlined-date-picker1">From</label>
                                                                </div>

                                                            </li>
                                                            <li class="{{$report_status=='expired'?'':'d-none'}}">

                                                                <div class="form-control-wrap focused" id="endReportDateDiv" data-reportenddate="@this">
                                                                    <div class="form-icon form-icon-right">
                                                                        <em class="icon ni ni-calendar-alt"></em>
                                                                    </div>
                                                                    <input type="text" class="form-control form-control-outlined date-picker" id="reportDateTo" wire:model.lazy="report_date_to" required>
                                                                    <label class="form-label-outlined" for="outlined-date-picker2">To</label>
                                                                </div>
                                                            </li>
                                                                <li class="nk-block-tools-opt">
                                                                    <button type="button" class="btn btn-primary"
                                                                            wire:click="showDiscountReport"><span> <em class="icon ni ni-trend-up"></em> Report</span></button>
                                                                </li>
                                                            <li class="nk-block-tools-opt {{$pdfReportReady==true?'':'d-none'}}">
                                                                <button type="button" class="btn btn-primary"
                                                                        wire:click="downloadPDF"><span><em class="icon ni ni-file-pdf"></em> PDF</span></button>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                </div>
                                            </div><!-- .nk-block-head-content -->
                                        </div><!-- .nk-block-between -->
                                    </div>
                                    <div id="" class=" dt-bootstrap4 no-footer">

                                        <div class=" my-3">
                                            @if(!empty($reportDiscount))
                                                <table class="nk-tb-list nk-tb-ulist no-footer" data-auto-responsive="false" id="" role="grid"
                                                       aria-describedby="DataTables_Table_1_info">
                                                    <thead>
                                                    <tr class="nk-tb-item nk-tb-head" role="row">

                                                        <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                            rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                                class="sub-text">Product</span></th>
                                                        <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                            rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                                class="sub-text">Size</span></th>
                                                        <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                            rowspan="1" colspan="1" aria-label="Verified: activate to sort column ascending">
                                                            <span class="sub-text">Retail Price</span></th>
                                                        <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                            rowspan="1" colspan="1" aria-label="Verified: activate to sort column ascending">
                                                            <span class="sub-text">Disc. Price</span></th>
                                                        <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                            rowspan="1" colspan="1" aria-label="Verified: activate to sort column ascending">
                                                            <span class="sub-text">Created</span></th>
                                                        <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                            rowspan="1" colspan="1" aria-label="Verified: activate to sort column ascending">
                                                            <span class="sub-text">Expiry</span></th>
                                                        <th class="nk-tb-col nk-tb-col-tools text-right sorting {{$report_status=='expired'?'d-none':''}}" tabindex="0"
                                                            aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="
                                                            : activate to sort column ascending">
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($reportDiscount as $discount)
                                                    <tr class="nk-tb-item odd" role="row">

{{--                                                        <td class="nk-tb-col">--}}
{{--                                                            <div class="user-card">--}}

{{--                                                                <div class="user-info">--}}
{{--                                                                    <span >{{$reportDiscount?\App\models\Branch::find($discount['branch_id'])->name:''}}</span>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </td>--}}
                                                        <td class="nk-tb-col">
                                                            <div class="user-card">

                                                                <div class="user-info">
                                                                    <span class="tb-lead">{{$reportDiscount?\App\models\Product::find($discount['product_id'])->name:''}}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <div class="user-card">

                                                                <div class="user-info">
                                                                    <span class="tb-lead">{{$reportDiscount?\App\models\Size::find($discount['size_id'])->name:''}}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <div class="user-card">

                                                                <div class="user-info">
                                                                    <span class="tb-lead">{{$reportDiscount?number_format(\App\models\ProductsAttribute::where('branch_id',$discount['branch_id'])->where('size_id',$discount['size_id'])->latest()->first()->price,2):''}}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <div class="user-card">

                                                                <div class="user-info">
                                                                    <span class="tb-lead">{{$reportDiscount?number_format($discount['amount'],2):''}}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <div class="user-card">

                                                                <div class="user-info">
                                                                    <span class="tb-lead">{{$reportDiscount?$discount['created_at']:''}}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col">
                                                            <div class="user-card">

                                                                <div class="user-info">
                                                                    <span class="tb-lead">{{$reportDiscount?$discount['expiry_date']:''}}</span>
                                                                    <span>{{$reportDiscount?\Carbon\Carbon::parse($discount['expiry_date'])->diffForHumans():''}}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="nk-tb-col nk-tb-col-tools {{$report_status=='expired'?'d-none':''}}">
                                                            <ul class="nk-tb-actions gx-1">

                                                                <li>
                                                                    <div class="drodown">
                                                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger"
                                                                           data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <ul class="link-list-opt no-bdr">
                                                                                <li><a wire:click="cancelDiscount({{$discount['id']}})">Cancel Discount</a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
