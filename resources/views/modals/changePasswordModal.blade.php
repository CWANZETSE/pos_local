<div class="modal fade zoom" tabindex="-1" id="changePasswordModal" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-12">
                        <div class="d-flex align-items-center">
                            <div class="w-100 d-block">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <form action="#" class="p-2">
                                                    <div class="form-group">
                                                        <label for="username">Password</label>
                                                        <input type="password" class="form-control @error('oldPassword') is-invalid @enderror" placeholder="" wire:model.lazy="oldPassword">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="emailaddress">New Password</label>
                                                        <input type="password" class="form-control @error('newPassword') is-invalid @enderror" placeholder="" wire:model.lazy="newPassword">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password">Repeat Password</label>
                                                        <input type="password" class="form-control @error('repeatNewPassword') is-invalid @enderror" placeholder="" wire:model.lazy="repeatNewPassword">
                                                    </div>
                                                    <div class="mb-3 text-center">
                                                        <button class="btn btn-primary btn-block" type="button" wire:click.prevent="changePassword"> Change Password </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- end card-body -->
                                        </div>
                                        <!-- end card -->



                                    </div>
                                    <!-- end col -->
                                </div>
                                <!-- end row -->
                            </div> <!-- end .w-100 -->
                        </div> <!-- end .d-flex -->
                    </div> <!-- end col-->
                </div> <!-- end row -->





            </div>
        </div>
    </div>
</div>