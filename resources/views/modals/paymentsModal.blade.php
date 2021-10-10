<div class="modal fade" id="PaymentsModal" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body" wire:loading.remove>

                <div class="card-body">
                    <div class="text-center">
                        <h4 class="card-title">COMPLETE BILL</h4>
                        <p class="card-subtitle mb-4">Select Pay Mode</p>
                    </div>

                    <div class="row">
                        <div class="col-sm-3 mb-2 mb-sm-0">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link show active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="false" wire:ignore.self>
                                    <i class="mdi mdi-home-variant d-lg-none d-block"></i>
                                    <span class="d-none d-lg-block">CASH</span>
                                </a>
                                <a class="nav-link {{\App\Models\GeneralSetting::first()?\App\Models\GeneralSetting::first()->kcb_pinpad===\App\Models\GeneralSetting::KCB_PINPAD_DISABLED?'d-none':'':''}}"" id=" v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">
                                    <i class="mdi mdi-account-circle d-lg-none d-block"></i>
                                    <span class="d-none d-lg-block">KCB PINPAD</span>
                                </a>
                                <a class="nav-link {{\App\Models\GeneralSetting::first()?\App\Models\GeneralSetting::first()->mpesa===\App\Models\GeneralSetting::MPESA_DISABLED?'d-none':'':''}}" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                                    <i class="mdi mdi-settings-outline d-lg-none d-block"></i>
                                    <span class="d-none d-lg-block">MPESA</span>
                                </a>
                            </div>
                        </div> <!-- end col-->

                        <div class="col-sm-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" wire:ignore.self>
                                    <div class="card-body">
                                            <div class="row">
                                                <div class="col-8">
                                                    <div class="form-group row mb-3">
                                                        <label for="inputEmail3" class="col-3 col-form-label">TOTAL</label>
                                                        <div class="col-9">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <button class="btn btn-primary   dropdown-toggle waves-effect waves-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">KSH</button>
                                                                    </div>
                                                                    <input type="number" class="form-control d-none" id="inputEmail3" disabled wire:model="totalBill">
                                                                    <label class="form-control alert-primary" style="border: 2px solid #D3D3D3FF;font-size: 20px;padding-bottom: 0;text-align: right;color: #f64b81;padding-right: 30px;background-color: #D3D3D3FF;">{{number_format($totalBill,2)}}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label for="inputPassword3" class="col-3 col-form-label">CASH PAY</label>
                                                        <div class="col-9">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <button class="btn btn-primary   dropdown-toggle waves-effect waves-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">KSH</button>
                                                                    </div>
                                                                    <input type="number" class="form-control" id="inputPassword3" wire:model.debounce.1000ms="cashPay" style="border: 2px solid lightgray;font-size: 20px;padding-bottom: 0;text-align: right;color: #f64b81;padding-right: 30px;background-color: #fff;">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-3">
                                                        <label for="inputPassword5" class="col-3 col-form-label">CHANGE</label>
                                                        <div class="col-9">
                                                            <div class="form-group">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <button class="btn btn-primary   dropdown-toggle waves-effect waves-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">KSH</button>
                                                                    </div>
                                                                    <input type="number" class="form-control d-none" id="inputPassword5" wire:model="change" disabled>
                                                                    <label class="form-control alert-primary" style="border: 2px solid lightgray;font-size: 20px;padding-bottom: 0;text-align: right;color: #f64b81;padding-right: 30px;background-color: #fff;">{{number_format($change,2)}}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="row">
                                                        <div class="col-md-12 form-group">
                                                            <button type="button" class="btn btn-sm btn-primary" style="width:65px;text-align: left;" wire:click="setCashPayDenomination(50)">KSH 50.00</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 form-group mt-20">
                                                            <button type="button" class="btn btn-sm btn-primary" style="width:65px;text-align: left;" wire:click="setCashPayDenomination(100)">KSH 100.00</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 form-group mt-20">
                                                            <button type="button" class="btn btn-sm btn-primary" style="width:65px;text-align: left;" wire:click="setCashPayDenomination(200)">KSH 200.00</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="row">
                                                        <div class="col-md-12 form-group mt-20">
                                                            <button type="button" class="btn btn-sm btn-primary" style="width:65px;text-align: left;" wire:click="setCashPayDenomination(500)">KSH 500.00</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 form-group mt-20">
                                                            <button type="button" class="btn btn-sm btn-primary" style="width:65px;text-align: left;" wire:click="setCashPayDenomination(1000)">KSH 1,000.00</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 form-group mt-20">
                                                            <button type="button" class="btn btn-sm btn-primary" style="width:65px;text-align: left;" wire:click="setCashExactAmountToTotalBill()">EQUALS TOTAL</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <div class="col-6">

                                            </div>
                                            <div class="col-6">
                                            <div class="form-group mb-0 justify-content-end row">
                                                        <div class="col-9">
                                                            <button type="button" class="btn btn-block btn-outline-primary" wire:click="cashSubmitPayment()">SUBMIT CASH</button>
                                                        </div>
                                                    </div>
                                            </div>
                                            </div>

                                       
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab" wire:ignore.self>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <i class="icofont icofont-apple-pay" style="font-size:50px;"></i>
                                                <i class="icofont icofont-visa-electron" style="font-size:50px;color: #6060de;"></i>
                                                <i class="icofont icofont-maestro-alt" style="font-size:50px;color:#34495E;"></i>
                                                <i class="icofont icofont-mastercard-alt" style="font-size:50px;color:#EB001B;"></i>
                                                <i class="icofont icofont-discover-alt" style="font-size:50px;color: #dd3a9b"></i>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                               
                                                    <input wire:model="change" class="form-control alert-primary" style="display: none" disabled>
                                                    <div class="form-group">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <button class="btn btn-primary   dropdown-toggle waves-effect waves-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">KSH</button>
                                                                    </div>
                                                    <label class="form-control alert-primary" style="border: 2px solid #D3D3D3FF;font-size: 30px;padding-bottom: 0;text-align: right;color: #f64b81;padding-right: 30px;background-color: #D3D3D3FF;">{{number_format($totalBill,2)}}</label>
                                                                </div>
                                                    </div>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-4">
                                                <input type="text" wire:model="responseCode" class="form-control" readonly>
                                            </div>
                                            <div class="col-sm-8">
                                                <input type="text" wire:model="responseMsg" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <input type="text" wire:model="ifCardPaySuccess" class="form-control" style="text-align: center;" readonly>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="form-control btn btn-md btn-primary" wire:click="CardPayments()">CARD PAY</button>
                                    </div>
                                </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                    MPESA
                                </div>
                            </div> <!-- end tab-content-->
                        </div> <!-- end col-->
                    </div>
                    <!-- end row-->
                </div> <!-- end card-body-->

            </div>

        </div>
    </div>
</div>