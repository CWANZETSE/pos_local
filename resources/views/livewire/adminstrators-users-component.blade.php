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
                        <span class="preview-title-lg overline-title">Administrators</span>
                        <div class="nk-block-des text-soft">
                            <p>Total of {{$count}} records found.</p>
                        </div>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <div class="toggle-wrap nk-block-tools-toggle">
                            <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em
                                    class="icon ni ni-more-v"></em></a>
                            <div class="toggle-expand-content" data-content="pageMenu">
                                <ul class="nk-block-tools g-3">
                                    <li>
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-right">
                                                <em class="icon ni ni-search"></em>
                                            </div>
                                            <input type="text" class="form-control" id="default-04"
                                                   placeholder="Quick Search" wire:model="search">
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-control-wrap ">
                                            <div class="form-control-select">
                                                <select class="form-control" wire:model="sorting">
                                                    <option value="default">Default</option>
                                                    <option value="active">Active</option>
                                                    <option value="disabled">Disabled</option>
                                                </select>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-control-wrap ">
                                            <div class="form-control-select">
                                                <select class="form-control" wire:model="pagesize">
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="15">15</option>
                                                    <option value="20">20</option>
                                                </select>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nk-block-tools-opt">
                                        <button type="button" class="btn btn-primary"
                                                wire:click="showCreateAdminModal"><em
                                                class="icon ni ni-plus"></em><span>Add Admin</span></button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div>
            <div id="" class=" dt-bootstrap4 no-footer">

                <div class=" my-3">
                    <table class="nk-tb-list nk-tb-ulist no-footer" data-auto-responsive="false" id="" role="grid"
                           aria-describedby="DataTables_Table_1_info">
                        <thead>
                        <tr class="nk-tb-item nk-tb-head" role="row">
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">No.</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">Name</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">Username</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">Role</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">Branch</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">Phone</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">Last Login</span></th>
                            <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"><span
                                    class="sub-text">Last Login Terminal</span></th>
                            <th class="nk-tb-col tb-col-lg sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                rowspan="1" colspan="1" aria-label="Verified: activate to sort column ascending">
                                <span class="sub-text">Status</span></th>
                            <th class="nk-tb-col nk-tb-col-tools text-right sorting" tabindex="0"
                                aria-controls="DataTables_Table_1" rowspan="1" colspan="1" aria-label="
                                                            : activate to sort column ascending">
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($admins as $key=>$admin)
                            <tr class="nk-tb-item odd {{$loop->odd?'bg-light':''}}" role="row">
                                <td class="nk-tb-col">
                                    <div class="user-card">
                                        <div class="user-info">
                                            <span class="tb-lead">{{$admins->firstItem()+$key}}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="nk-tb-col">
                                    <div class="user-card">
                                        <div class="user-info">
                                            <span class="tb-lead">{{$admin->name}}</span>
                                            <span>{{$admin->email}}</span>
                                        </div>
                                    </div>
                                </td>


                                <td class="nk-tb-col tb-col-lg">
                                    <div class="user-info">
                                        <span class="tb-lead">{{$admin->username}}</span>
                                    </div>
                                </td>
                                <td class="nk-tb-col tb-col-lg">
                                    <div class="user-info">
                                        <span class="tb-lead">{{$admin->role_id==1?"Administrator":"Manager"}}</span>
                                    </div>
                                </td>
                                <td class="nk-tb-col tb-col-lg">
                                    <div class="user-info">
                                        <span
                                            class="tb-lead">{{$admin->role_id==2?\App\Models\Branch::find($admin->branch_id)->name:""}}</span>
                                    </div>
                                </td>
                                <td class="nk-tb-col tb-col-lg">
                                    <div class="user-info">
                                        <span class="tb-lead">{{$admin->phone}}</span>
                                    </div>
                                </td>
                                <td class="nk-tb-col tb-col-lg">
                                    <div class="user-info">
                                        <span class="tb-lead">{{$admin->last_login}}</span>
                                        <span>@if(is_null($admin->last_login)) @else {{Carbon\Carbon::parse($admin->last_login)->diffForHumans()}} @endif</span>
                                    </div>
                                </td>
                                <td class="nk-tb-col tb-col-lg">
                                    <div class="user-info">
                                        <span class="tb-lead">{{$admin->last_login_ip}}</span>
                                        <span>{{$admin->last_login_mac}}</span>
                                    </div>
                                </td>
                                <td class="nk-tb-col tb-col-lg" data-order="Email Verified - Kyc Unverified">
                                    <em
                                        class="icon {{$admin->status?'text-success':'text-danger'}} {{$admin->status?'ni ni-check-circle':'ni ni-alert-circle'}}"></em>
                                    <span
                                        class="tb-status {{$admin->status?'text-success':'text-danger'}}">{{$admin->status?'Active':'Deactivated'}}</span>
                                </td>
                                <td class="nk-tb-col nk-tb-col-tools">
                                    <ul class="nk-tb-actions gx-1">

                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger"
                                                   data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a data-toggle="modal"
                                                               wire:click.prevent="changeToUpdatingMode({{$admin->id}})"><em
                                                                    class="icon ni ni-account-setting"></em><span>Update
                                                                </span></a></li>
                                                        <li><a href="#"
                                                               wire:click.prevent="changeAdminPassword({{$admin->id}})"><em
                                                                    class="icon ni ni-lock-fill"></em><span>Reset Password</span></a>
                                                        </li>
                                                        <li><a href="#" wire:click.prevent="ShowUserlogsModal({{$admin->id}})"><em class="icon ni ni-lock-fill"></em><span>System Logs</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="row align-items-center">
                    {{ $admins->links('pagination.admin') }}
                </div>
            </div>
        </div>
    </div>
    @include('modals.addEditAdminModal')
    @include('modals.ShowUserLogsModal')
</div>
