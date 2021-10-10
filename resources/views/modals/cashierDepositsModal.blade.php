<div class="modal fade" id="viewDepositsModal" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <div class="row" wire:loading.delay>
                    <div class="loader-block">
                        <svg id="loader2" viewBox="0 0 100 100">
                            <circle id="circle-loader2" cx="50" cy="50" r="45"></circle>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <p>Request Failed to Submit</p>
                        </div>
                        @endif
                        @if($maximumErrorMsg)
                        <div class="alert alert-danger">
                            <p>There was an error. Maximum Cash of Ksh {{number_format($undeclared,2)}}</p>
                        </div>
                        @endif
                        @if($zeroErrorMsg)
                        <div class="alert alert-danger">
                            <p>There was an error. You cannot declare Ksh {{number_format($this->state['amount'],2)}}</p>
                        </div>
                        @endif
                        @if($successMsg)
                        <div class="alert alert-primary">
                            <p>Declaration is submitted for approval</p>
                        </div>
                        @endif
                    </div>

                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        <div class="card-block table-border-style">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">UNDECLARED CASH (KSH)</th>
                                            <td>{{number_format($undeclared,2)}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">CASH IN TILL (KSH)</th>
                                            <td>{{number_format(($pendingDeclarationsSum+$undeclared),2)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-4">
                        <input type="number" placeholder="Amount" class="form-control @error('amount') is-invalid @enderror" id="name" aria-describedby="amount" wire:model.lazy="state.amount">
                    </div>
                    <div class="col-md-4">
                        <select name="select" class="form-control" id="branch" wire:model="state.destination">
                            <option value="">--Select--</option>
                            <option value="admin">Admin</option>
                            <option value="expense" disabled>Expense</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary" wire:click="DeclareCash()">SUBMIT</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title overflow-hidden">Todays Summary</h4>
                                <p class="card-subtitle mb-4 font-size-13 overflow-hidden">{{date('D, d-M-Y')}} {{auth()->user()->name}}
                                </p>

                                <div class="table-responsive">
                                    <table class="table table-centered table-bordered table-hover table-xl mb-0" id="recent-orders">
                                        <thead>
                                            <tr>
                                                <th class="border-top-0">Item</th>
                                                <th class="border-top-0 text-right">Amount (Ksh)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                                <td>Cash Sales</td>
                                                <td class="text-right">{{number_format($totalCashSales,2)}}</td>
                                            </tr>
                                            <tr>
                                                <td>KCB Pinpad Sales</td>
                                                <td class="text-right">{{number_format($totalCardSales,2)}}</td>
                                            </tr>
                                            <tr>
                                                <td>Pending Approval Cash Declaration</td>
                                                <td class="text-right">{{number_format($pendingDeclarationsSum,2)}}</td>
                                            </tr>
                                            <tr>
                                                <td>Declined Approval Cash Declaration</td>
                                                <td class="text-right">{{number_format($declinedDeclarationsSum,2)}}</td>
                                            </tr>
                                            <tr>
                                                <td>Approved Cash Declaration</td>
                                                <td class="text-right">{{number_format($approvedDeclarationsSum,2)}}</td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>

                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col -->


                </div>
            </div>
        </div>
    </div>
</div>