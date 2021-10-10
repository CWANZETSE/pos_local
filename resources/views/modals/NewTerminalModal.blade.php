<div class="modal fade zoom" tabindex="-1" id="addEditTerminalModal" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$updatingMode?'Update Terminal':'New Terminal'}}</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-inner">
                            
                            <form autocomplete="off" wire:submit.prevent="{{$updatingMode ? 'updateTerminal':'AddTerminal'}}">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">MAC Address</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('mac_address') is-invalid @enderror" id="mac_address" aria-describedby="name" wire:model.lazy="mac_address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Current IP Address</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('ip_address') is-invalid @enderror" id="ip_address" aria-describedby="ip_address" wire:model.lazy="ip_address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Location</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" aria-describedby="location" wire:model.lazy="location">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Terminal Status Configuration</label>
                                            <ul class="custom-control-group g-3 align-center">
                                                <li>
                                                    <div class="col-md-3 col-sm-6">
                                                        <div class="preview-block">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch2" wire:model="status">
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