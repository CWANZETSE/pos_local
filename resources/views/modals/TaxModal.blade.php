<div class="modal fade zoom" tabindex="-1" id="TaxModal" wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tax</h5>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-inner">
                        <div class="example-alert mb-5 {{$success_creating_tax_msg?'':'d-none'}}">
                            <div class="alert alert-success alert-icon">
                                Tax created successfully!
                            </div>
                        </div>
                        <div class="example-alert mb-5 {{$success_updating_tax_msg?'':'d-none'}}">
                            <div class="alert alert-success alert-icon">
                                Tax updated successfully!
                            </div>
                        </div>
                        <form autocomplete="off" wire:submit.prevent="{{$updatingTaxMode ? 'updateTax':'AddNewTax'}}">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Tax Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text"  class="form-control @error('tax_name') is-invalid @enderror" id="tax_name" aria-describedby="new_account_number" wire:model.lazy="tax_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Percentage</label>
                                        <div class="form-control-wrap">
                                            <input type="number"  class="form-control @error('percentage') is-invalid @enderror" id="percentage" aria-describedby="percentage" wire:model.lazy="percentage">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary">{{$updatingTaxMode ? 'Update Tax':'Add New Tax'}}</button>
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
                                                        class="sub-text">Date</span></th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                        class="sub-text">Tax Code</span></th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                        class="sub-text">Percentage</span></th>
                                                <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                    rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                                        class="sub-text"></span></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($tax_details as $tax)
                                                <tr class="nk-tb-item odd {{$loop->odd?'bg-light':''}}" role="row">
                                                    <td class="nk-tb-col">
                                                        <div class="user-card">

                                                            <div class="user-info">
                                                                <span class="tb-lead">{{$tax['created_at']}}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <div class="user-card">

                                                            <div class="user-info">
                                                                <span class="tb-lead">{{$tax['tax_name']}}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <div class="user-card">
                                                            <div class="user-info">
                                                                <span class="tb-lead">{{$tax['percentage']}} <span class="dot dot-success d-md-none ml-1"></span></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="nk-tb-col">
                                                        <div class="user-card">
                                                            <button type="button" class="btn btn-lg btn-warning btn-sm"><em class="icon ni ni-pen2" wire:click="ChangeToTaxUpdatingMode({{$tax['id']}})"></em></button>
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
