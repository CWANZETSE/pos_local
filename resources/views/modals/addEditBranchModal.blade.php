<div class="modal fade zoom" tabindex="-1" id="addEditBranchModal" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$updatingMode?'Update Branch':'New Branch'}}</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-inner">

                            <form autocomplete="off" wire:submit.prevent="{{$updatingMode ? 'updateBranch':'AddBranch'}}">
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
                                            <label class="form-label" for="full-name-1">Location</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" aria-describedby="name" wire:model.lazy="state.location">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Unbanked Balance</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('unbanked_balance') is-invalid @enderror" id="unbanked_balance" aria-describedby="name" wire:model.lazy="state.unbanked_balance" placeholder="0.00" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Till Configuration</label>
                                            <ul class="custom-control-group g-3 align-center">
                                                <li>
                                                    <div class="col-md-3 col-sm-6">
                                                        <div class="preview-block">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch2" wire:model="state.till_status" {{$viewingMode? 'disabled':''}}>
                                                                <label class="custom-control-label" for="customSwitch2">Status</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
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
