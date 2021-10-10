<html lang="en">

<head>
    <meta charset="utf-8">
    <title>EOD Report</title>

    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
        /* baloo-paaji-2-regular - latin */
        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 100%;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family:monospace;
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
            color: #0e70d3;
            font-size: 2.0em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            /*background: #020c19;*/
            text-decoration: underline;
            padding:7px;
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
            /*border-bottom: 1px solid #C1CED9;*/
            white-space: nowrap;
            font-weight: normal;
            text-align: left;
        }

        table .service,
        table .desc {
            text-align: right;
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
            text-align:left;
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
        <img src="{{ public_path('storage/logos/'.$headerLogo) }}" alt="Logo">
    </div>
    <h1>END OF DAY REPORT</h1>

    <div class="project">
        <div><span>STORE</span> {{$branch}}</div>
        <div><span>FROM DATE</span> {{$from}}</div>
        <div><span>TO DATE</span> {{$to}}</div>
        <div><span>CURRENCY</span> Kenya Shillings</div>

    </div>
</header>
<main>

    <div style="padding:5px; background:#1273eb;color:white;">
        <div><p>CASH SALES</p></div>
    </div>
    <table>
        <thead>
        <tr>
            <th class="cpt_no">CASHIER NAME</th>
            <th class="service">AMOUNT</th>

        </tr>
        </thead>
        <tbody>
        <?php $CashTotal=0; ?>
        @foreach($totalUserCashSales as $sale)
            <tr>

                <td style="text-align:left">{{$sale->user->name}}</td>
                <td class="service">{{number_format($sale->amount,2)}}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
    <div style="padding:5px; background:#1273eb;color:white;">
        <div><p>CASH SALE REVERSALS</p></div>
    </div>
    <table>
        <thead>
        <tr>
            <th class="cpt_no">SALE ID</th>
            <th class="cpt_no">CASHIER</th>
            <th class="cpt_no">REVERSED BY</th>
            <th class="service">AMOUNT</th>

        </tr>
        </thead>
        <tbody>

        @foreach($branch_sales as $sale)
            @if(in_array($sale->id,$cashpay_ids))
            <tr>

                <td style="text-align:left">{{$sale->txn_code}}</td>
                <td style="text-align:left">{{$sale->user->name}}</td>
                <td style="text-align:left">{{\App\Models\Admin::find($sale->canceled_by)->name}}</td>
                <td class="service">{{number_format(($sale->total),2)}}</td>

            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
    <div style="padding:5px; background:#1273eb;color:white;">
        <div><p>KCB PINPAD SALES</p></div>
    </div>
    <table>
        <thead>
        <tr>
            <th class="cpt_no">CASHIER NAME</th>
            <th class="service">TOTAL AMT</th>

        </tr>
        </thead>
        <tbody>
        @foreach($totalUserCardSales as $sale)
            <tr>

                <td style="text-align:left">{{$sale->user->name}}</td>
                <td class="service">{{number_format(($sale->TransactionAmount),2)}}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
    <div style="padding:5px; background:#1273eb;color:white;">
        <div><p>KCB PINPAD SALE REVERSALS</p></div>
    </div>
    <table>
        <thead>
        <tr>
            <th class="cpt_no">SALE ID</th>
            <th class="cpt_no">CASHIER</th>
            <th class="cpt_no">REVERSED BY</th>
            <th class="service">AMOUNT</th>

        </tr>
        </thead>
        <tbody>

        @foreach($branch_sales as $sale)
            @if(in_array($sale->id,$cardpay_ids))
                <tr>

                    <td style="text-align:left">{{$sale->txn_code}}</td>
                    <td style="text-align:left">{{$sale->user->name}}</td>
                    <td style="text-align:left">{{\App\Models\Admin::find($sale->canceled_by)->name}}</td>
                    <td class="service">{{number_format(($sale->total),2)}}</td>

                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
    <div style="padding:5px; background:#1273eb;color:white;">
        <div><p>SUMMARY</p></div>
    </div>
    <table>
        <tbody>
            <tr>
                <td class="cpt_no">Cash Sales</td>
                <td style="text-align:right">{{number_format($CashSalesAmount,2)}}</td>
            </tr>
            <tr>
                <td class="cpt_no">Card Sales</td>
                <td style="text-align:right">{{number_format($CardSalesAmount,2)}}</td>
            </tr>
            <tr>
                <td class="cpt_no">Cash Reversals</td>
                <td style="text-align:right">{{number_format($totalCashReversed,2)}}</td>
            </tr>
            <tr>
                <td class="cpt_no">Card Reversals</td>
                <td style="text-align:right">{{number_format($totalCardReversed,2)}}</td>
            </tr>
            <tr>
                <td class="cpt_no">Cash Collected</td>
                <td style="text-align:right">{{number_format($CashSalesAmount-$totalCashReversed,2)}}</td>
            </tr>

        </tbody>
    </table>
    <div class="project">
        <div><span>MANAGER NAME</span> ----------------</div>
        <div><span>MANAGER SIGN</span> ----------------</div>
        <div><span>DATETIME</span>----------------</div>
        <div><span>STAMP</span>----------------</div>
    </div>
</main>
<footer>
    Report Printed By {{Auth::user()->name}} on {{(Carbon\Carbon::now())->toDayDateTimeString()}}
</footer>

</body>

</html>
