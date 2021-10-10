<div class="modal fade zoom" tabindex="-1" id="AdminChangePasswordModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <div class="card">
                    <div class="card-inner">
                        <div class="card-head">
                            <h5 class="card-title">Change Password</h5>
                        </div>
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-label" for="default-06">Old Password</label>
                                            <input type="password" class="form-control @error('oldPassword') is-invalid @enderror" id="oldPassword" wire:model.lazy="oldPassword">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-06">New Password</label>
                                    <div class="form-control-wrap ">
                                            <input type="password" class="form-control @error('newPassword') is-invalid @enderror" id="newPassword" wire:model.lazy="newPassword">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="default-06">Repeat New Password</label>
                                    <div class="form-control-wrap ">
                                            <input type="password" class="form-control @error('repeatNewPassword') is-invalid @enderror" id="repeatNewPassword" wire:model.lazy="repeatNewPassword">
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group">
                                    <button type="button" class="btn btn-lg btn-primary" wire:click="changePassword">Change Password</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
