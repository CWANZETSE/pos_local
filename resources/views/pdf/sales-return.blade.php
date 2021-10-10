<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sales Reversals Statement</title>
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
            text-align:right;
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
    <h1>SALES REVERSALS STATEMENT</h1>

    <div class="project">
        <div><span>STORE</span> {{$branch}}</div>
        <div><span>FROM DATE</span> {{$from}}</div>
        <div><span>TO DATE</span> {{$to}}</div>
        <div><span>SALES ORDERS</span> {{$sales->count()}}</div>
        <div><span>CURRENCY</span> Kenya Shillings</div>
    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <!-- <th class="service">SERVICE</th>
            <th class="desc">DESCRIPTION</th> -->
            <th>Date</th>
            <th>Authoriser</th>
            <th>Sale ID</th>
            <th>Items</th>
            <th>Amount</th>
            <th>Tax</th>
            @if(auth()->user()->role_id==\App\Models\Admin::IS_ADMINISTRATOR)
                <th>Margin</th>
            @endif
        </tr>
        </thead>
        <tbody>

        <?php $total=0;?>
        <?php $total_qty=0;?>

        <?php $total_margin=0;?>
        <?php $total_tax=0;?>
        <?php $CardPaymentSum=0;?>
        <?php $CashPaymentSum=0;?>
        @foreach($sales as $order)
            <?php $sale_qty=0;?>
            @foreach(unserialize($order->sale) as $product)
                <?php $sale_qty+=$product['quantity'];?>
                <?php $total_qty+=$product['quantity'];?>
            @endforeach
            <?php $total+=$order->total;?>
            <?php $total_margin+=$order->margin;?>
            <?php $total_tax+=$order->tax;?>
            <?php $CardPaymentSum+=\App\Models\CardPayment::where('sale_id',$order['id'])?\App\Models\CardPayment::where('sale_id',$order['id'])->sum('TransactionAmount'):0;?>
            <?php $CashPaymentSum+=\App\Models\CashPayment::where('sale_id',$order['id'])?\App\Models\CashPayment::where('sale_id',$order['id'])->sum('total'):0;?>
            <tr>
                <td class="service">{{($order->created_at)}}</td>
                <td class="service">{{\App\Models\Admin::find($order->canceled_by)->name}}</td>
                <td class="service">{{$order->txn_code}}</td>
                <td class="total">{{$sale_qty}}</td>
                <td class="total">{{number_format($order->total,2)}}</td>
                <td class="total">{{number_format($order->tax,2)}}</td>
                @if(auth()->user()->role_id==\App\Models\Admin::IS_ADMINISTRATOR)
                    <td class="total">{{number_format($order->margin,2)}}</td>
                @endif
            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="project">
        <div><span>TOTAL SALES AMT</span> {{number_format($total,2)}}</div>
        <div><span>TOTAL TAX AMT</span> {{number_format($total_tax,2)}}</div>
        @if(auth()->user()->role_id==\App\Models\Admin::IS_ADMINISTRATOR)
            <div><span>TOTAL MARGIN AMT</span> {{number_format($total_margin,2)}}</div>
        @endif
    </div>
</main>
<footer>
    Sales Return Statement Generated by {{auth()->user()->name}} on {{(Carbon\Carbon::now())->toDayDateTimeString()}}
</footer>

</body>

</html>
