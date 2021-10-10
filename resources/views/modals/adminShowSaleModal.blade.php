<div class="modal fade zoom" tabindex="-1" id="adminShowSaleModal" wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <div class="card">
                    <div class="card-inner">
                        <div class="row g-4 {{$canceled_by===null?"d-none":""}}">
                            <div class="example-alert">
                                <div class="alert alert-pro alert-danger">
                                    <div class="alert-text">
                                        <h6>Sale Reversed</h6>
                                        <p>This cannot be undone. You may place a new sale</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-06">Transaction Code</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="default-01" placeholder="{{$txn_code}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-06">Cashier</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="default-01" placeholder="{{$user}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-05">Total Sale Amount (Ksh)</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="default-05" placeholder="{{number_format($SaleAmount,2)}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-05">Sale DateTime</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="default-05" placeholder="{{$created_at}}" disabled>
                                    </div>
                                </div>
                            </div>
                            @if($canceled_by===1)

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="default-05">Reversed By</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="default-05" placeholder="{{$canceled_by===null?'':\App\Models\Admin::find($canceled_by)->name}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="default-05">Reversed DateTime</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="default-05" placeholder="{{$reversed_on}}" disabled>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(auth()->user()->role_id==\App\Models\Admin::IS_ADMINISTRATOR)
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-05">Terminal</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="default-05" placeholder="{{$mac_address}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-05">IP</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="default-05" placeholder="{{$ip_address}}" disabled>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class=" my-3">
                                <table class="nk-tb-list nk-tb-ulist no-footer" data-auto-responsive="true" id="" role="grid"
                                       aria-describedby="DataTables_Table_1_info">
                                    <thead>
                                    <tr class="nk-tb-item nk-tb-head" role="row">
                                        <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                class="sub-text">SKU</span></th>
                                        <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                class="sub-text">Product Name</span></th>
                                        <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                class="sub-text">Size</span></th>
                                        <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                class="sub-text">Price</span></th>
                                        <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                class="sub-text">Qty</span></th>
                                        <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                class="sub-text">Amount</span></th>
                                        <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                class="sub-text">Tax</span></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($items as $key=>$item)
                                        <tr class="nk-tb-item odd" role="row">
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead">{{($item['sku'])}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead">{{($item['product_name'])}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead">{{$item['size']}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead" style="text-align:right !important;">{{number_format($item['price'],2)}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead" style="text-align:right !important;">{{$item['quantity']}}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead" style="text-align:right !important;">{{number_format(($item['quantity']*$item['price']),2)}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead" style="text-align:right !important;">{{\App\Models\Size::find($item['size_id'])->taxable?number_format(((\App\Models\GeneralSetting::first()->tax_percentage/100)*($item['quantity']*$item['price'])),2):0.00}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach



                                    </tbody>
                                </table>
                            </div>


                            <div class=" my-3">
                                <table class="nk-tb-list nk-tb-ulist no-footer" data-auto-responsive="true" id="" role="grid"
                                       aria-describedby="DataTables_Table_1_info">
                                    <thead>
                                    <tr class="nk-tb-item nk-tb-head" role="row">
                                        <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                class="sub-text">CASH AMOUNT (KSH)</span></th>
                                        <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                class="sub-text">CARD AMOUNT (KSH)</span></th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                        <tr class="nk-tb-item odd" role="row">

                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                         {{number_format((\App\Models\CashPayment::where('sale_id',$sale_id)->first()?\App\Models\CashPayment::where('sale_id',$sale_id)->latest()->first()->total:0.00),2)}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead">{{\App\Models\CardPayment::where('sale_id',$sale_id)->first()?(number_format((\App\Models\CardPayment::where('sale_id',$sale_id)->first()->TransactionAmount),2)):0.00}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <div id="accordion" class="accordion {{\App\Models\CardPayment::where('sale_id',$sale_id)->first()?'':'d-none'}}">
                                    <div class="accordion-item">
                                        <a href="#" class="accordion-head" data-toggle="collapse" data-target="#accordion-item-1">
                                            <p>Card Payment Details</p>
                                        </a>
                                        <div class="accordion-body collapse" id="accordion-item-1" data-parent="#accordion">
                                            <div class="accordion-inner">
                                                <table class="table table-bordered {{$CardPaymentDetails!=null?'':'d-none'}}">
                                                    <thead>
                                                    <tr>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <th>Auth Code</th>
                                                        <td>{{$CardPaymentDetails!=null?$CardPaymentDetails['authCode']:''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>RRN</th>
                                                        <td>{{$CardPaymentDetails!=null?$CardPaymentDetails['rrn']:''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>AMOUNT</th>
                                                        <td>{{$CardPaymentDetails!=null?$CardPaymentDetails['TransactionAmount']:''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>PAN</th>
                                                        <td>{{$CardPaymentDetails!=null?$CardPaymentDetails['pan']:''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>TID</th>
                                                        <td>{{$CardPaymentDetails!=null?$CardPaymentDetails['tid']:''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>PAY DETAILS</th>
                                                        <td>{{$CardPaymentDetails!=null?$CardPaymentDetails['payDetails']:''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>DATETIME</th>
                                                        <td>{{$CardPaymentDetails!=null?$CardPaymentDetails['created_at']:''}}</td>
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
            </div>
            </form>
        </div>
    </div>
</div>
