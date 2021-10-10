<div class="topnav" wire:ignore.self>
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">

                <div class="card-body">
                    <div class="form-inline">
                        <div class="form-group mx-sm-3">
                            <input type="number" wire:model="searchByCode" wire:keyup.enter="searchResultsByCode" class="form-control" placeholder="Scan Barcode">
                        </div>
                        <button type="button" class="btn btn-primary waves-effect waves-light" wire:click="ShowSearchModal">SEARCH PRODUCT <i class="bx bx-search-alt-2"></i></button>
                    </div>
                </div> <!-- end card-body-->
            </div>
        </nav>
    </div>

    @include('modals.ShowSearchModal')
    @include('modals.ProductSelectedModal')
</div>