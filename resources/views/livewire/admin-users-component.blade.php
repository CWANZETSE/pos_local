<div class="nk-content p-0">
    <div class="nk-content-inner">
        <div class="col-lg-12" style="text-align:center">
            <div wire:loading>
                <div class="form-group">
                    <span class="text-danger">Please wait...</span>
                </div>
                <div class="spinner-border text-primary" role="status">
                </div>
            </div>
        </div>
        <div class="nk-content-body">
            <div class="nk-ibx">
                <div class="nk-ibx-aside toggle-screen-lg" data-content="inbox-aside" data-toggle-overlay="true"
                     data-toggle-screen="lg">
                    <div class="nk-ibx-head {{auth()->user()->role_id==\App\Models\Admin::IS_MANAGER?'d-none':''}}">
                        <button type="submit" class="btn btn-lg btn-primary" wire:click.prevent="AdminUserCreate"><em class="icon ni ni-plus"></em>New Cashier
                        </button>
                    </div>
                    <div class="nk-ibx-head">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>Cashier(s)</td>
                                <td>{{$searched_users_count}}</td>
                            </tr>
                            <tr>
                                <td>Open Till(s)</td>
                                <td>{{$active_till_users_count}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div style="padding:0.5rem;">
                        <div class="form-group">
                            <input type="text"
                                   class="form-control @error('search') is-invalid @enderror"
                                   id="phone"
                                   placeholder="Search Cashier Name"
                                   aria-describedby="search"
                                   wire:model="search">
                        </div>
                    </div>
                    <div class="nk-ibx-nav" data-simplebar="init">
                        <div class="simplebar-wrapper" style="margin: 0px;">
                            <div class="simplebar-height-auto-observer-wrapper">
                                <div class="simplebar-height-auto-observer">
TEST
                                </div>
                            </div>
                            <div class="simplebar-mask mt-3">
                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;background-color:#f0d4e7;">
                                    <div class="simplebar-content-wrapper"
                                         style="height: 100%; overflow: hidden scroll;">
                                        <div class="simplebar-content" style="padding: 0px;">
                                            <ul class="nk-ibx-contact mt-3">
                                                @foreach($cashiers as $cashier)
                                                    <li style="{{$selectedUserId==$cashier->id?'background: #1273eb;color:#fff !important;':''}}">
                                                    <a href="#" wire:click.prevent="ViewUserProfile({{$cashier->id}})">
                                                        <div class="user-card">
                                                            <div class="user-info">
                                                                <span class="preview-title-lg overline-title" style="{{$selectedUserId==$cashier->id?'color:#fff !important;':''}}">{{$cashier->name}}</span>
                                                                <span class="text-white">Till {{$cashier->assigned_till?'Open':'Closed'}}</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                @endforeach
                                                @if(count($cashiers)==0)
                                                    <div class="example-alert">
                                                        <div class="alert alert-pro alert-danger">
                                                            <div class="alert-text">
                                                                <h6>Not Found</h6>
                                                                <p>Cashier(s) Not Found</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- .nk-ibx-aside -->
                <div class="nk-ibx-body bg-white">
                    <div class="nk-ibx-head">


                        <!-- .search-wrap -->
                    </div><!-- .nk-ibx-head -->
                    <div class="nk-ibx-list" data-simplebar="init">
                        <div class="simplebar-wrapper" style="margin: 0px;">
                            <div class="simplebar-height-auto-observer-wrapper">
                                <div class="simplebar-height-auto-observer"></div>
                            </div>
                            <div class="simplebar-mask">
                                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                    <div class="simplebar-content-wrapper"
                                         style="height: 100%; overflow: hidden scroll;">
                                        <div class="simplebar-content" style="padding: 0px;">
                                            <div class="nk-ibx-item">
                                                <div>
                                                    @if ($showUserProfile)
                                                        @livewire('admin-user-view-profile-component')
                                                    @elseif($showUserlogs)
                                                        @livewire('admin-user-view-logs-component')
                                                    @elseif($showUserCreate)
                                                        @livewire('admin-user-create-component')
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="simplebar-placeholder" style="width: 323px; height: 1797px;"></div>
                    </div>
                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                    </div>
                    <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                        <div class="simplebar-scrollbar"
                             style="height: 83px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                    </div>
                </div><!-- .nk-ibx-list -->

            </div><!-- .nk-ibx-body -->
        </div><!-- .nk-ibx -->
    </div>

    <style>
        .table th, .table td {
             border-top: 0px solid #dbdfea;
        }
    </style>

</div>

