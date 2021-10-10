<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sales Statement</title>
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
            padding:2px;
            font-size: 0.8em;
        }

        #company {
            float: right;
            text-align: right;
        }

        .project div,
        #company div {
            white-space: nowrap;
            padding:2px;
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
            text-align: left;
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
    <h1>PROFIT AND LOSS REPORT</h1>

    <div class="project">
        <div><span>STORE</span> {{$branch}}</div>
        <div><span>FROM DATE</span> {{$from}}</div>
        <div><span>TO DATE</span> {{$to}}</div>
        <div><span>CURRENCY</span> Kenya Shillings</div>
    </div>
</header>
<main>
    <table>
        <tbody>

        <?php $totalMargin=0;?>
        <?php $total_qty=0;?>
        <?php $bp=0;?>
        <?php $sp=0;?>

        <thead>
        <tr>
            <!-- <th class="service">SERVICE</th>
            <th class="desc">DESCRIPTION</th> -->
            <th></th>
            <th>Buy</th>
            <th>Sell</th>
            <th>Quantity</th>
            <th>Margin</th>
        </tr>
        </thead>
        @foreach($profits as $profit)

            <?php $totalMargin+=$profit->margin;?>
            <?php $total_qty+=$profit->quantity;?>
            <?php $bp+=$profit->buy_total;?>
            <?php $sp+=$profit->sell_total;?>


        @endforeach
        <tr>
            <td class="service">Totals</td>
            <td class="service">{{number_format($bp,2)}}</td>
            <td class="service">{{number_format($sp,2)}}</td>
            <td class="total">{{$total_qty}}</td>
            <td class="total">{{number_format($totalMargin,2)}}</td>
        </tr>
        <tr>
            <td class="service">Average Per Unit</td>
            <td class="service">{{number_format($bp/$total_qty,2)}}</td>
            <td class="service">{{number_format($sp/$total_qty,2)}}</td>
            <td class="total">{{$total_qty/$total_qty}}</td>
            <td class="total">{{number_format($totalMargin/$total_qty,2)}}</td>
        </tr>
        </tbody>
    </table>

</main>
<footer>
    P and L Statement Generated on {{(Carbon\Carbon::now())->toDayDateTimeString()}}
</footer>

</body>

</html>
