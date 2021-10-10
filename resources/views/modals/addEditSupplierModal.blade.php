<div class="modal fade zoom" tabindex="-1" id="addEditSupplierModal" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$updatingMode?'Update Supplier':'New Supplier'}}</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-inner">

                            <form autocomplete="off" wire:submit.prevent="{{$updatingMode ? 'updateSupplier':'AddSupplier'}}">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Name</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="name" wire:model.lazy="state.name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Postal Address</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" aria-describedby="name" wire:model.lazy="state.address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Contact</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('contact') is-invalid @enderror" id="contact" aria-describedby="name" wire:model.lazy="state.contact">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Email</label>
                                            <div class="form-control-wrap">
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="name" wire:model.lazy="state.email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Supplier Status</label>
                                            <ul class="custom-control-group g-3 align-center">
                                                <li>
                                                    <div class="col-md-3 col-sm-6">
                                                        <div class="preview-block">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch2" wire:model="state.status" {{$viewingMode? 'disabled':''}}>
                                                                <label class="custom-control-label" for="customSwitch2">Status</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Invoice Due Days</label>
                                            <div class="form-control-wrap ">
                                                <div class="form-control-select">
                                                    <select class="form-control @error('invoice_due_days') is-invalid @enderror" wire:model="state.invoice_due_days">
                                                        <option value="">--Select Days--</option>
                                                        <option value="0">0</option>
                                                        <option value="7">7</option>
                                                        <option value="14">14</option>
                                                        <option value="30">30</option>
                                                        <option value="60">60</option>
                                                        <option value="90">90</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <div class="form-group">

                        <button type="submit" class="btn btn-lg btn-primary">Save Information</button>

                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
