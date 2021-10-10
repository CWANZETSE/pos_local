<div class="modal fade zoom" tabindex="-1" id="AdminViewSupplierAccountModal" wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$bank_supplier_name}}</h5>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-inner">
                        <form autocomplete="off" wire:submit.prevent="{{$updatingBankMode ? 'updateBank':'AddNewBank'}}">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Bank Name</label>
                                        <div class="form-control-select">
                                            <select class="form-control @error('new_bank_name') is-invalid @enderror" id="default-06" wire:model="new_bank_name">
                                                <option value="">--Select Bank--</option>
                                                <option value="KCB Bank">KCB Bank</option>
                                                <option value="UBA Kenya Bank Ltd">UBA Kenya Bank Ltd</option>
                                                <option value="Co-operative Bank">Co-operative Bank</option>
                                                <option value="Standard Investment Bank">Standard Investment Bank</option>
                                                <option value="Standard Chartered">Standard Chartered</option>
                                                <option value="Prime Bank">Prime Bank</option>
                                                <option value="Paramount Bank">Paramount Bank</option>
                                                <option value="Oriental Commercial Bank Ltd">Oriental Commercial Bank Ltd</option>
                                                <option value="NIC Bank">NIC Bank</option>
                                                <option value="ABC Bank">ABC Bank</option>
                                                <option value="National Bank">National Bank</option>
                                                <option value="K-Rep Bank">K-Rep Bank</option>
                                                <option value="Kenya Post Office Savings Bank">Kenya Post Office Savings Bank</option>
                                                <option value="Investments & Mortgages Bank Limited – I&M Bank">Investments & Mortgages Bank Limited – I&M Bank</option>
                                                <option value="Imperial Bank Limited">Imperial Bank Limited</option>
                                                <option value="Housing Finance">Housing Finance</option>
                                                <option value="Guardian Bank Ltd">Guardian Bank Ltd</option>
                                                <option value="Giro Commercial Bank Ltd">Giro Commercial Bank Ltd</option>
                                                <option value="Fina Bank">HFina Bank</option>
                                                <option value="Fidelity Bank">Fidelity Bank</option>
                                                <option value="Faida Investment Bank – FIB">Faida Investment Bank – FIB</option>
                                                <option value="Equity Bank">Equity Bank</option>
                                                <option value="Equatorial Investment Bank">Equatorial Investment Bank</option>
                                                <option value="Equatorial Commercial Bank Limited">Equatorial Commercial Bank Limited</option>
                                                <option value="Dyer & Blair Investment Bank">Dyer & Blair Investment Bank</option>
                                                <option value="Dubai Bank Kenya Ltd">Dubai Bank Kenya Ltd</option>
                                                <option value="Development Bank Of Kenya Ltd">Development Bank Of Kenya Ltd</option>
                                                <option value="Consolidated Bank">Consolidated Bank</option>
                                                <option value="Commercial Bank of Africa">Commercial Bank of Africa</option>
                                                <option value="Citibank N A">Citibank N A</option>
                                                <option value="Chase Bank">Chase Bank</option>
                                                <option value="CFC Stanbic Bank Limited">CFC Stanbic Bank Limited</option>
                                                <option value="Bank Of Baroda (Kenya) Ltd">Bank Of Baroda (Kenya) Ltd</option>
                                                <option value="CBank of Africa Kenya Ltd">Bank of Africa Kenya Ltd</option>
                                                <option value="African Banking Corporation">African Banking Corporation</option>
                                                <option value="Mpesa Till">Mpesa Till</option>
                                                <option value="Mpesa Number">Mpesa Number</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Bank Account Number</label>
                                        <div class="form-control-wrap">
                                            <input type="number"  class="form-control @error('new_account_number') is-invalid @enderror" id="new_account_number" aria-describedby="new_account_number" wire:model.lazy="new_account_number">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="phone-no-1">Bank Additional Details</label>
                                        <div class="form-control-wrap">
                                            <textarea class="form-control @error('new_bank_additional_details') is-invalid @enderror no-resize" id="new_bank_additional_details" placeholder="Bank Account Details" wire:model="new_bank_additional_details"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-primary">{{$updatingBankMode ? 'Update Bank':'Add New Bank'}}</button>
                                </div>
                            </div>
                        </div>
                        </form>
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div id="" class=" dt-bootstrap4 no-footer">

                                    <div class=" my-3">
                                        <table class="nk-tb-list nk-tb-ulist no-footer" data-auto-responsive="false" id="" role="grid"
                                               aria-describedby="DataTables_Table_1_info">
                                            <thead>
                                            <tr class="nk-tb-item nk-tb-head" role="row">
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                        class="sub-text">Bank</span></th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                        class="sub-text">Account No.</span></th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                        class="sub-text">Bank Details</span></th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                        class="sub-text"></span></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($bank_details as $bank)
                                                <tr class="nk-tb-item odd {{$loop->odd?'bg-light':''}}" role="row">
                                                    <td class="nk-tb-col">
                                                        <div class="user-card">

                                                            <div class="user-info">
                                                                <span class="tb-lead">{{$bank['bank_name']}}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <div class="user-card">
                                                            <div class="user-info">
                                                                <span class="tb-lead">{{$bank['account_number']}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <div class="user-card">

                                                            <div class="user-info">
                                                                <span class="tb-lead">{{$bank['bank_additional_details']}}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <div class="user-card">
                                                            <button type="button" class="btn btn-lg btn-warning btn-sm"><em class="icon ni ni-pen2" wire:click="ChangeToBankUpdatingMode({{$bank['id']}})"></em></button>
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
    </div>
</div>
