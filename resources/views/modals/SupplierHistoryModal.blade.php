
<div class="modal fade" id="SupplierHistoryModal" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

                    <div class="row g-gs">
                        <div class="col-sm-12 col-lg-12 col-xxl-12">
                            <div class="card">
                                <div class="card-inner">
                                    <div class="team">
                                        <div class="user-card user-card-s2">
                                            <div class="user-info">
                                                <h6>{{$supplier_code}}   {{$supplier_name}}</h6>
                                                <span class="sub-text">Summary</span>
                                            </div>
                                        </div>
                                        <ul class="team-statistics">
                                            <li><span>Ksh {{number_format($total_invoices_amt,2)}}</span><span>Total Invoices ({{$total_invoices_count}})</span></li>
                                            <li><span>Ksh {{number_format($paid_invoices_amt,2)}}</span><span>Paid Invoices ({{$paid_invoices_count}})</span></li>
                                            <li><span>Ksh {{number_format($pending_invoices_amt,2)}}</span><span>Pending Invoices ({{$pending_invoices_count}})</span></li>
                                        </ul>
                                        <ul class="team-statistics">
                                            <li><span>{{$first_created}}</span><span>First Invoice </span></li>
                                            <li><span>{{$last_created}}</span><span>Last Invoice </span></li>
                                            <li><span>{{$last_paid}}</span><span>Last Paid Date</span></li>
                                        </ul>
                                    </div><!-- .team -->
                                </div><!-- .card-inner -->
                            </div><!-- .card -->
                        </div>
                    </div>

            </div>
        </div>
    </div>
</div>

