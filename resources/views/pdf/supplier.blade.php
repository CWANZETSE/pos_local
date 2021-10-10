<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Supplier Summary</title>
    <style>
    .clearfix:after {
        content: "";
        display: table;
        clear: both;
    }

    a {
        color: #5D6975;
        text-decoration: underline;
    }
    table thead{
        background-color: #1273eb;
        color:#fff !important;
    }

    body {
        position: relative;
        width: 100%;
        height: 29.7cm;
        margin: 0 auto;
        color: #001028;
        background: #FFFFFF;
        font-family: monospace;
        /* font-family: Arial, sans-serif; */
        font-size: 12px;
        /* font-family: Arial; */
    }

    header {
        padding: 10px 0;
        margin-bottom: 30px;
    }

    #logo {
        text-align: center;
        margin-bottom: 10px;
    }

    #logo img {
        /* width: 100%; */
    }

    h1 {
        border-top: 0px solid #5D6975;
        border-bottom: 0px solid #5D6975;
        color: #5D6975;
        font-size: 2.0em;
        line-height: 1.4em;
        font-weight: normal;
        text-align: center;
        margin: 0 0 20px 0;
        background: #DCDCDC;
    }

    .project {
        float: right;
    }

    .project span {
        color: #5D6975;
        text-align: right;
        width: 52px;
        margin-right: 10px;
        display: inline-block;
        padding: 2px;
        font-size: 0.8em;
    }

    #company {
        float: right;
        text-align: right;
    }

    .project div,
    #company div {
        white-space: nowrap;
        padding: 2px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 20px;
    }

    table tr:nth-child(2n-1) td {
        background: #F5F5F5;
    }

    table th,
    table td {
        text-align: center;
    }

    table th {
        padding: 5px 10px;
        color: #5D6975;
        border-bottom: 1px solid #C1CED9;
        white-space: nowrap;
        font-weight: normal;
    }

    table .service,
    table .desc {
        text-align: left;
    }

    table td {
        padding: 10px;
        text-align: right;
    }

    table td.service,
    table td.desc {
        vertical-align: top;
    }

    table td.unit,
    table td.qty,
    table td.total {
        font-size: 1.0em;
    }

    table td.grand {
        border-top: 1px solid #5D6975;
        ;
    }

    #notices .notice {
        color: #5D6975;
        font-size: 1.2em;
    }

    footer {
        color: #5D6975;
        width: 100%;
        height: 30px;
        position: absolute;
        bottom: 0;
        border-top: 1px solid #C1CED9;
        padding: 8px 0;
        text-align: center;
    }
    </style>
</head>

<body>
    <header class="clearfix">
        <div id="logo">
             <img src="{{ public_path('storage/logos/'.$logo) }}">
        </div>
        <h1>SUPPLIER SUMMARY</h1>

        <div class="project">
            <div><span>SUPPLIER</span> {{$supplier_code}} {{$supplier}}</div>
            <div><span>FROM DATE</span> {{$from}}</div>
            <div><span>TO DATE</span> {{$to}}</div>
            <div><span>PURCHASES RECORDED</span> {{$purchases->count()}}</div>
            <div><span>CURRENCY</span> Kenya Shillings</div>
        </div>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th class="cpt_no">DATE</th>
                    <th class="cpt_no">INVOICE ID</th>
                    <th class="cpt_no">STOCK</th>
                    <th class="cpt_no">TOTAL</th>
                    <th class="cpt_no">CANCELED</th>
                    <th class="cpt_no">PAYMENT STATUS</th>
                </tr>
            </thead>
            <tbody>


            <?php $total_stock=0 ?>
            <?php $total_cost=0 ?>
            @foreach($purchases as $purchase)
                @foreach(unserialize($purchase->order_data) as $key=>$data)
                    <?php $total_stock+=$data['stock'] ?>
                    <?php $total_cost+=$data['stock']*$data['cost'] ?>
                @endforeach

                <tr>
                    <td class="service">{{($purchase['created_at'])}}</td>
                    <td class="service">{{$purchase['invoice_id']}}</td>
                    <td class="service">{{$total_stock}}</td>
                    <td class="service">{{number_format($total_cost,2)}}</td>
                    <td class="service">{{$purchase['canceled']==0?'NO':'Yes'}}</td>
                    <td class="service">{{$purchase['payment_status']==0?'PENDING':'PAID'}}</td>

                </tr>

                @endforeach
            </tbody>
        </table>
        <div class="project">

            <?php $pendingCost=0;?>
            @foreach($pending_purchases as $cost)
                    @foreach(unserialize($purchase->order_data) as $key=>$data)
                        <?php $pendingCost+=$data['stock']*$data['cost'] ?>
                    @endforeach
            @endforeach
            <?php $paidCost=0;?>
            @foreach($paid_purchases as $paidcost)
                    @foreach(unserialize($purchase->order_data) as $key=>$data)
                        <?php $paidCost+=$data['stock']*$data['cost'] ?>
                    @endforeach
            @endforeach

            <div><span>TOTAL PENDING AMOUNT</span> {{number_format($pendingCost,2)}}</div>
            <div><span>TOTAL PAID AMOUNT</span> {{number_format($paidCost,2)}}</div>
            <div><span>CANCELED INVOICES</span> {{$canceled_purchases}}</div>
        </div>
    </main>
    <footer>
        Supplier Statement Generated by {{auth()->user()->name}} on {{(Carbon\Carbon::now())->toDayDateTimeString()}}
    </footer>

</body>

</html>
