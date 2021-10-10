<div class="modal fade zoom" tabindex="-1" id="addEditAdminModal" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$updatingMode?'Update Admin':'New Admin'}}</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-inner">

                            <form autocomplete="off" wire:submit.prevent="{{$updatingMode ? 'updateAdmin':'AddAdmin'}}">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Name</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror  id="name" aria-describedby="name" wire:model="state.name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Email</label>
                                            <div class="form-control-wrap">
                                                <input type="email" class="form-control @error('email') is-invalid @enderror  id="email" aria-describedby="email" wire:model.lazy="state.email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Username</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('username') is-invalid @enderror id="username" aria-describedby="username" wire:model.lazy="state.username">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Phone</label>
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control @error('phone') is-invalid @enderror  id="phone" aria-describedby="phone" wire:model.lazy="state.phone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Role</label>
                                            <div class="form-control-select">
                                                <select class="form-control @error('role_id') is-invalid @enderror" id="role_id" wire:model="role_id">
                                                    <option value="">--Select Role--</option>
                                                    <option value="1">Administrator</option>
                                                    <option value="2">Manager</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Branch</label>
                                            <div class="form-control-select">
                                                <select class="form-control @error('branch_id') is-invalid @enderror" id="branch_id" wire:model="branch_id" {{$role_id==2? 'required':''}} {{$role_id==1? 'disabled':''}}>
                                                    <option value="">--Select Branch--</option>
                                                    @foreach($branches as $branch)
                                                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Password</label>
                                            <div class="form-control-wrap">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror  id="password" aria-describedby="password" wire:model="state.password" {{$updatingMode?'disabled':''}}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Status</label>
                                            <ul class="custom-control-group g-3 align-center">
                                                <li>
                                                    <div class="col-md-3 col-sm-6">
                                                        <div class="preview-block">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch2" wire:model="state.status">
                                                                <label class="custom-control-label" for="customSwitch2"></label>
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
