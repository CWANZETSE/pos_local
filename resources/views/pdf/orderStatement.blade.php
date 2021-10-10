<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Orders Statement</title>
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
        .signature span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            padding:10px;
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

        table tr td {
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
    <h1>PURCHASE ORDERS</h1>

    <div class="project">
        <div><span>STORE</span>{{strtoupper($branch)}}</div>
        <div><span>FROM DATE</span> {{$from}}</div>
        <div><span>TO DATE</span> {{$to}}</div>
        <div><span>CURRENCY</span> Kenya Shillings</div>
    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th class="cpt_no">CREATED</th>
            <th class="cpt_no">ORDER ID</th>
            <th class="cpt_no">SUPPLIER</th>
            <th class="cpt_no">AMOUNT</th>
            <th class="cpt_no">STATUS</th>
        </tr>
        </thead>
        <tbody>


        <?php $total=0;?>

        @foreach($orders as $order)
            <?php $total+=$order->order_total;?>
            <tr>
                <td class="service">{{$order->created_at}}</td>
                <td class="service">{{$order->order_id}}</td>
                <td class="service">{{$order->supplier->supplier_code}} {{$order->supplier->name}}</td>
                <td class="total">{{number_format($order->order_total,2)}}</td>
                <td class="total">@if($order->status==0) PENDING @elseif($order->status==1) RECEIVED @else DECLINED @endif</td>
            </tr>

        @endforeach
        </tbody>
    </table>
    <div class="project">
        <div><span>TOTAL</span> {{number_format($total,2)}}</div>
    </div>
    <div class="signature">
        <div><span>MANAGER SIGN</span> --------------------</div>
        <div><span>DATE</span> --------------------</div>
        <div><span>STAMP</span> --------------------</div>
    </div>
</main>
<footer>
    Invoices Statement Generated by {{auth()->user()->name}} on {{(Carbon\Carbon::now())->toDayDateTimeString()}}
</footer>

</body>

</html>
