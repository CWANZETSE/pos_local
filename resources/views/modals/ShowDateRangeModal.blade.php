<div class="modal fade zoom" tabindex="-1" id="ShowDateRangeModal" wire:ignore.self>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-gs">
                    <div class="col-lg-12" style="text-align:center">
                        <div class="alert alert-primary">
                            <div wire:loading>
                                <div class="form-group">
                                    <span class="text-danger">Please wait...</span>
                                </div>
                                <div class="spinner-border text-primary" role="status">
                                </div>
                            </div>
                            <span class="preview-title-lg overline-title" wire:loading.remove>{{$selectedPeriod}}</span>
                        </div>
                    </div>
                </div>
                <div class="row g-gs">
                    <div class="col-lg-6">

                    </div>
                    <div class="col-lg-6">
                        <div class="project">
                            <div><span>FROM DATE</span> <span class="preview-title-lg overline-title">{{$date_from===null||$date_from===""?'--':\Carbon\Carbon::parse($date_from)->format('l, d F Y')}}</span></div>
                            <div><span>TO DATE</span> <span class="preview-title-lg overline-title">{{$date_to===null||$date_to===""?'--':\Carbon\Carbon::parse($date_to)->format('l, d F Y')}}</span></div>

                        </div>
                    </div>

                </div>
                <div class="row g-gs">
                    <div class="col-lg-6">
                        <div class="card h-100">
                            <div class="card-inner">
                                <div class="card-head">
                                    <span class="preview-title-lg overline-title">custom dates</span>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-control-wrap focused" id="startDateDiv" data-startdate="@this">
                                            <div class="form-icon form-icon-right">
                                                <em class="icon ni ni-calendar-alt"></em>
                                            </div>
                                            <input type="text" class="form-control form-control-outlined date-picker" id="startingDate" wire:model.lazy="date_from" required>
                                            <label class="form-label-outlined" for="outlined-date-picker1">From</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-control-wrap focused" id="endDateDiv" data-enddate="@this">
                                            <div class="form-icon form-icon-right">
                                                <em class="icon ni ni-calendar-alt"></em>
                                            </div>
                                            <input type="text" class="form-control form-control-outlined date-picker" id="endingDate" wire:model.lazy="date_to" required>
                                            <label class="form-label-outlined" for="outlined-date-picker2">To</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card h-100">
                            <div class="card-inner">
                                <div class="card-head">
                                    <span class="preview-title-lg overline-title">predefined period</span>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <button class="btn btn-outline-light w-100" wire:click="PredefinedPeriod('today')">Today</button>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-outline-light w-100" wire:click="PredefinedPeriod('this_week')">This Week</button>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-outline-light w-100" wire:click="PredefinedPeriod('this_month')">This Month</button>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-outline-light w-100" wire:click="PredefinedPeriod('this_year')">This Year</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                         <button class="btn btn-outline-light w-100" wire:click="PredefinedPeriod('yesterday')">Yesterday</button>
                                        </div>

                                        <div class="form-group">
                                         <button class="btn btn-outline-light w-100" wire:click="PredefinedPeriod('last_week')">Last Week</button>
                                        </div>

                                        <div class="form-group">
                                        <button class="btn btn-outline-light w-100" wire:click="PredefinedPeriod('last_month')">Last Month</button>
                                        </div>
                                        <div class="form-group">
                                        <button class="btn btn-outline-light w-100" wire:click="PredefinedPeriod('last_year')">Last Year</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>
