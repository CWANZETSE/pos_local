<div class="modal fade zoom" tabindex="-1" id="addEditCashiersModal" wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$updatingMode ? 'Update Cashier':'New Cashier'}}</h5>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-inner">

                        <form autocomplete="off" wire:submit.prevent="{{$updatingMode ? 'updateCashier':'AddCashier'}}">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Store</label>
                                        <div class="form-control-select">
                                            <select class="form-control @error('branch_id') is-invalid @enderror"
                                                    id="default-06"
                                                    wire:model="state.branch_id" {{auth()->user()->role_id==\App\Models\Admin::IS_MANAGER?'disabled':''}}>
                                                <option value="">--Select Store--</option>
                                                @foreach($branches as $branch)
                                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="form-note">Branch of Cashier</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="name"
                                                   wire:model="state.name" {{auth()->user()->role_id==\App\Models\Admin::IS_MANAGER?'disabled':''}}>
                                        </div>
                                        <span class="form-note">Official Name of User</span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Email</label>
                                        <div class="form-control-wrap">
                                            <input type="email"
                                                   class="form-control @error('email') is-invalid @enderror" id="email"
                                                   aria-describedby="email"
                                                   wire:model.lazy="state.email" {{auth()->user()->role_id==\App\Models\Admin::IS_MANAGER?'disabled':''}}>
                                        </div>
                                        <span class="form-note">Valid email address</span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Username</label>
                                        <div class="form-control-wrap">
                                            <input type="text"
                                                   class="form-control @error('username') is-invalid @enderror"
                                                   id="username" aria-describedby="username"
                                                   wire:model.lazy="state.username" {{auth()->user()->role_id==\App\Models\Admin::IS_MANAGER?'disabled':''}}>
                                        </div>
                                        <span class="form-note">Used for login purposes</span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Phone</label>
                                        <div class="form-control-wrap">
                                            <input type="number"
                                                   class="form-control @error('phone') is-invalid @enderror" id="phone"
                                                   aria-describedby="phone"
                                                   wire:model.lazy="state.phone" {{auth()->user()->role_id==\App\Models\Admin::IS_MANAGER?'disabled':''}}>
                                        </div>
                                        <span class="form-note">Mobile phone number</span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Password</label>
                                        <div class="form-control-wrap">
                                            <input type="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   id="password" aria-describedby="password"
                                                   wire:model="state.password" {{$updatingMode? 'disabled':''}}>
                                        </div>
                                        <span class="form-note">System login password</span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <ul class="custom-control-group g-3 align-center">
                                            <li>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="preview-block">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input"
                                                                   id="customSwitch2"
                                                                   wire:model="state.status" {{auth()->user()->role_id==\App\Models\Admin::IS_MANAGER?'disabled':''}}>
                                                            <label class="custom-control-label" for="customSwitch2">User
                                                                Enabled</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <span class="form-note">Toggle to activate or deactivate user</span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">

                                        <ul class="custom-control-group g-3 align-center">
                                            <li>
                                                <div class="col-md-3 col-sm-6">
                                                    <div class="preview-block">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input"
                                                                   id="assigned_till" wire:model="state.assigned_till"
                                                                   disabled>
                                                            <label class="custom-control-label"
                                                                   for="assigned_till">Till</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <span class="form-note">User currently has active till?</span>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Receipt and Drawer</label>
                                        <div class="form-control-select">
                                            <select class="form-control @error('print_receipt') is-invalid @enderror"
                                                    id="default-06" wire:model="state.print_receipt">
                                                <option value="0">Print No | Drawer No</option>
                                                <option value="1">Print Yes | Drawer Yes</option>
                                                <option value="2">Print Yes | Drawer No</option>
                                                <option value="3">Print No | Drawer Yes</option>

                                            </select>
                                        </div>
                                        <span class="form-note">Printer and Cash Drawer</span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Printer IP</label>
                                        <div class="form-control-wrap">
                                            <input type="text"
                                                   class="form-control @error('printer_ip') is-invalid @enderror id="
                                                   printer_ip" aria-describedby="printer_ip"
                                            wire:model.lazy="state.printer_ip" placeholder="192.168.1.X">
                                        </div>
                                        <span class="form-note">On Same network</span>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label" for="full-name-1">Printer PORT</label>
                                        <div class="form-control-wrap">
                                            <input type="number" placeholder="9100"
                                                   class="form-control @error('printer_port') is-invalid @enderror  id="
                                                   printer_port" aria-describedby="printer_port"
                                            wire:model.lazy="state.printer_port" value="9100">
                                        </div>
                                        <span class="form-note">Default '9100'</span>
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
