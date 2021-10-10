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
            <div class="nk-block-head nk-block-head-sm">
                <div class="nk-block-between">
                    <div class="nk-block-head-content">
                        <span class="preview-title-lg overline-title">admin change password</span>
                    </div>
                    <div class="nk-block-head-content">
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
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div>

        </div>
    </div>
</div>
