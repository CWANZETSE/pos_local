<div class="modal fade" id="ShowUserLogsModal" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card card-preview">
                    <div class="card-inner">
                        <div class="nk-block-head nk-block-head-sm">
                            <div class="nk-block-between">
                                <div class="nk-block-head-content">
                                    <span class="preview-title-lg overline-title">{{$user_name}} system logs</span>
                                    <div class="nk-block-des text-soft">

                                    </div>
                                </div><!-- .nk-block-head-content -->
                                <div class="nk-block-head-content">
                                    <div class="toggle-wrap nk-block-tools-toggle">
                                        <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1"
                                           data-target="pageMenu"><em
                                                class="icon ni ni-more-v"></em></a>
                                        <div class="toggle-expand-content" data-content="pageMenu">
                                            <ul class="nk-block-tools g-3">
                                                <li class="{{$reportReady?'':'d-none'}}">
                                                    <div class="form-control-select">
                                                        <select class="form-control" id="default-06"
                                                                wire:model="perPage" {{auth()->user()->role_id==\App\Models\Admin::IS_MANAGER?'disabled':''}}>
                                                            <option value="1">1</option>
                                                            <option value="10">10</option>
                                                            <option value="20">20</option>
                                                            <option value="30">30</option>
                                                            <option value="50">50</option>
                                                        </select>
                                                    </div>
                                                </li>
                                                <li>
                                                    <button type="button" class="btn btn-primary"
                                                            wire:click="ShowDateRangeModal()">Select Date
                                                    </button>
                                                </li>
                                                <li class="{{$reportReady?'':'d-none'}}">
                                                    <a href="#" class="btn btn-secondary"
                                                       wire:click.prevent="downloadLogsPDF"><em
                                                            class="icon ni ni-download text-light"></em> PDF
                                                        <div class="ml-3" wire:loading>
                                                            @include('loaders.loader6')
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head-content -->
                            </div><!-- .nk-block-between -->
                        </div>
                        <div id="" class=" dt-bootstrap4 no-footer">

                            <div class=" my-3">
                                <table class="nk-tb-list nk-tb-ulist no-footer" data-auto-responsive="false" id=""
                                       role="grid"
                                       aria-describedby="DataTables_Table_1_info">
                                    <thead>
                                    <tr class="nk-tb-item nk-tb-head" role="row">
                                        <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1"
                                            aria-label="User: activate to sort column ascending"><span
                                                class="sub-text">DateTime</span></th>
                                        <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1"
                                            aria-label="User: activate to sort column ascending"><span
                                                class="sub-text">Event</span></th>
                                        <th class="nk-tb-col sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                            rowspan="1" colspan="1" aria-label="User: activate to sort column ascending"
                                            style="text-align: right"><span
                                                class="sub-text">IP</span></th>

                                    </tr>

                                    </thead>
                                    <tbody>
                                    @foreach($user_data as $user)
                                        <tr class="nk-tb-item odd" role="row">

                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead">{{$user->created_at}}</span></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="tb-lead">{{$user->event}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="nk-tb-col">
                                                <div class="user-card">
                                                    <div class="user-info">
                                                        <span class="tb-lead"
                                                              style="text-align:right !important;">{{$user->ip}}</span>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            @include('modals.ShowDateRangeModal')
                            <div class="row align-items-center">

                            </div>
                        </div>
                        <div class="row align-items-center">
                            @if(!empty($user_data)){{ $user_data->links('pagination.admin') }}@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

