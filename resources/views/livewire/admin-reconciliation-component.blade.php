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
            @if($successUpdating)
                <div class="example-alert mb-3">
                    <div class="alert alert-success success-icon">
                        <em class="icon ni ni-alert-circle"></em> Cash Deposit decisioned successfully</div>
                </div>
            @endif
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <h3 class="nk-block-title page-title">Reconciliation</h3>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li class="nk-block-tools-opt">
                                        <button class="btn btn-primary " wire:click="CreateFloat()"><em class="icon ni ni-plus"></em><span>Create Float</span></button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- .nk-block-head-content -->
                </div>
            </div>
            <div id="" class=" dt-bootstrap4 no-footer">

                <div class="card card-preview">
                    <div class="card-inner">
                        <ul class="nav nav-tabs mt-n3">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabItem5"><em class="icon ni ni-alert-circle text-warning"></em> <span>Pending ({{$pendingDeclarations->count()}})</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabItem6"><em class="icon ni ni-clipboad-check text-success"></em><span>Approved ({{$approvedDeclarations->count()}})</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabItem7"><em class="icon ni ni-cross-circle text-danger"></em><span>Declined ({{$declinedDeclarations->count()}})</span></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabItem5">
                                <div class=" my-3" style="height: 350px;overflow-x: auto;overflow-y: auto;">
                                    <table class="nk-tb-list nk-tb-ulist no-footer" data-auto-responsive="false" id="" role="grid"
                                           aria-describedby="DataTables_Table_1_info">
                                        <thead>
                                        <tr class="nk-tb-item nk-tb-head" role="row">
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">DateTime</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Ref.</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Branch</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Cashier</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Amount</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Recipient</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Check</span></th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($pendingDeclarations as $txn)
                                            <tr class="nk-tb-item odd" role="row">

                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->created_at}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->reference}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->branch->name}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->user->name}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">Ksh {{number_format($txn->amount,2)}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->destination}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span wire:click="showCheckCashierDepositModal({{$txn->id}})" style="font-size: 20px;" class="text-primary"><em class="icon ni ni-edit"></em></span>
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabItem6">
                                <div class=" my-3" style="height: 350px;overflow-x: auto;overflow-y: auto;">
                                    <table class="nk-tb-list nk-tb-ulist no-footer" data-auto-responsive="false" id="" role="grid"
                                           aria-describedby="DataTables_Table_1_info">
                                        <thead>
                                        <tr class="nk-tb-item nk-tb-head" role="row">
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Submited</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Approved</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Ref.</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Branch</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Cashier</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Amount</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Recipient</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Approver</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Comments</span></th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($approvedDeclarations as $txn)
                                            <tr class="nk-tb-item odd" role="row">

                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->created_at}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->updated_at}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->reference}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->branch->name}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->user->name}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">Ksh {{number_format($txn->amount,2)}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->destination}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->admin->name}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->comments}}</span>
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabItem7">
                                <div class=" my-3" style="height: 350px;overflow-x: auto;overflow-y: auto;">
                                    <table class="nk-tb-list nk-tb-ulist no-footer" data-auto-responsive="false" id="" role="grid"
                                           aria-describedby="DataTables_Table_1_info">
                                        <thead>
                                        <tr class="nk-tb-item nk-tb-head" role="row">
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Submited</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Declined</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Ref.</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Branch</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Cashier</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Amount</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Recipient</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Approver</span></th>
                                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                    class="sub-text">Comments</span></th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($declinedDeclarations as $txn)
                                            <tr class="nk-tb-item odd" role="row">

                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->created_at}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->updated_at}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->reference}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->branch->name}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->user->name}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">Ksh {{number_format($txn->amount,2)}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->destination}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->admin->name}}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="nk-tb-col">
                                                    <div class="user-card">

                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$txn->comments}}</span>
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
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

    @include('modals.AdminCashierDepositModal')
    @include('modals.AdminFloatModal')

</div>

