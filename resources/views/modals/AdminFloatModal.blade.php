<div class="modal fade zoom" tabindex="-1" id="adminFloatModal" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <div class="card">
                    <div class="card-inner">
                        <div class="card-head">
                            <h5 class="card-title">New Float</h5>
                        </div>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="default-06">Branch</label>
                                        <div class="form-control-wrap ">
                                            <div class="form-control-select">
                                                <select class="form-control" id="default-06" wire:model="selected_branch_id">
                                                    <option value="">--Select Branch--</option>
                                                    @foreach($branches as $branch)
                                                            <option value="{{$branch->id}}">{{$branch->name}}</option>
                                                     @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="default-06">Cashier</label>
                                        <div class="form-control-wrap ">
                                            <div class="form-control-select">
                                                <select class="form-control" id="default-06" wire:model="user_id">
                                                    <option value="">--Select Cashier--</option>
                                                    @foreach($users as $user)
                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label" for="default-05">Amount</label>
                                            <div class="form-control-wrap">
                                                <div class="form-text-hint">
                                                    <span class="overline-title">Ksh</span>
                                                </div>
                                                <input type="number" class="form-control" id="default-05" placeholder="0.00" wire:model="amount">
                                            </div>
                                        </div>

                                    <div class="form-group">
                                        <label class="form-label">Approve</label>
                                        <ul class="custom-control-group g-3 align-center">
                                            <li>
                                                <div class="custom-control custom-control-sm custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="com-email-1" wire:model="checked" {{$readyForSaving?"":"disabled"}}>
                                                    <label class="custom-control-label" for="com-email-1">Confirm Ksh {{$amount!==null?number_format($amount,2):0}}</label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>



                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-lg btn-primary" wire:click="SaveFloat()" {{$checked?'':'disabled'}}>Save Float</button>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
