<div class="modal fade zoom" tabindex="-1" id="adminShowSaleModal" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <div class="card">
                    <div class="card-inner">
                        <div class="row g-4">
                            <div class="col-lg-12 {{$canceled_by!=null?'':'d-none'}}">
                                <div class="form-group">
                                    <div class="alert alert-danger alert-icon">
                                        <em class="icon ni ni-alert-circle"></em> <strong>Reversed Sale</strong> </div>
                                </div>
                            </div>
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
                                    <label class="form-label" for="default-05">Total Sale Amount</label>
                                    <div class="form-control-wrap">
                                        <div class="form-text-hint">
                                            <span class="overline-title">Ksh</span>
                                        </div>
                                        <input type="text" class="form-control" id="default-05" placeholder="{{number_format($SaleAmount,2)}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-05">DateTime</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="default-05" placeholder="{{$created_at}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-05">Reversed</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="default-05" placeholder="{{$updated_at}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-05">TAT</label>
                                    <div class="form-control-wrap">
                                        <input type="text" class="form-control" id="default-05" placeholder="{{$updated_at!==null && $created_at!=null?$updated_at->diffForHumans($created_at):''}}" disabled>
                                    </div>
                                </div>
                            </div>
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

                                    @foreach($items as $item)
                                        <tr class="nk-tb-item odd" role="row">

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
                                                class="sub-text">CASH</span></th>
                                        <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                class="sub-text">MPESA</span></th>
                                        <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                class="sub-text">CARD</span></th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    <tr class="nk-tb-item odd" role="row">

                                        <td class="nk-tb-col">
                                            <div class="user-card">

                                                <div class="user-info">
                                                    Tendered: Ksh {{number_format((\App\Models\CashPayment::where('sale_id',$sale_id)->first()?\App\Models\CashPayment::where('sale_id',$sale_id)->first()->tendered:0.00),2)}} </br> Change: Ksh {{\App\Models\CashPayment::where('sale_id',$sale_id)->first()?number_format((\App\Models\CashPayment::where('sale_id',$sale_id)->first()->change),2):0.00}}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            <div class="user-card">

                                                <div class="user-info">
                                                    <span class="tb-lead">Ksh {{\App\Models\Mpesa::where('BillRefNumber',$sale_id)->first()?(number_format((\App\Models\Mpesa::where('BillRefNumber',$sale_id)->first()->TransAmount),2)):0.00}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            <div class="user-card">

                                                <div class="user-info">
                                                    <span class="tb-lead">Ksh {{\App\Models\CardPayment::where('sale_id',$sale_id)->first()?(number_format((\App\Models\CardPayment::where('sale_id',$sale_id)->first()->TransactionAmount),2)):0.00}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                                <div id="accordion" class="accordion">
                                    <div class="accordion-item">
                                        <a href="#" class="accordion-head" data-toggle="collapse" data-target="#accordion-item-1">
                                            <p>Payment Details (Mpesa & Card)</p>
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
