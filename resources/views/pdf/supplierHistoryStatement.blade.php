<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Supplier Statement</title>
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
            font-size: 9px;
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
    <h1>SUPPLIER STATEMENT</h1>

    <div class="project">
        <div><span>SUPPLIER</span> {{$supplier_code}} {{$supplier_name}}</div>
        <div><span>FROM DATE</span> {{$from}}</div>
        <div><span>TO DATE</span> {{$to}}</div>
        <div><span>CURRENCY</span> Kenya Shillings</div>
    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th style="text-align:left;">DATE</th>
            <th  style="text-align:left;">INVOICE ID</th>
            <th  style="text-align:left;">DESCRIPTION</th>
            <th  style="text-align:right;">MONEY IN</th>
            <th  style="text-align:right;">MONEY OUT</th>
            <th  style="text-align:right;">BALANCE</th>
        </tr>
        </thead>
        <tbody>


        <?php $total_stock=0 ?>

        @foreach($histories as $history)

            <tr>
                <td class="service">{{(Carbon\Carbon::parse($history->created_at))->format('d-m-Y')}}</td>
                <td class="service">{{$history->invoice_id}}</td>
                <td class="service">{{$history->description}}</td>
                <td style="text-align:right;">{{$history->money_in!==null?number_format($history->money_in,2):''}}</td>
                <td style="text-align:right;">{{$history->money_out!==null?'-':''}}{{$history->money_out!==null?number_format($history->money_out,2):''}}</td>
                <td style="text-align:right;">{{number_format($history->balance,2)}}</td>
            </tr>

        @endforeach
        </tbody>
    </table>
    <div class="project">
        <div><span>TOTAL MONEY IN</span> {{number_format($sumMoneyIn,2)}}</div>
        <div><span>TOTAL MONEY OUT</span> -{{number_format($sumMoneyOut,2)}}</div>
        <div><span>CLOSING BALANCE</span> {{number_format($finalBalance,2)}}</div>
    </div>
</main>
<footer>
    Supplier Statement Generated by {{auth()->user()->name}} on {{(Carbon\Carbon::now())->toDayDateTimeString()}}
</footer>

</body>

</html>
