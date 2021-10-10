<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Purchase Order</title>
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
            padding:2px;
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
    <h1>PURCHASE ORDER</h1>

    <div class="project">
        <div><span>STORE</span> {{$orderData->branch->name}}</div>
        <div><span>ORDER ID</span> LPO{{$orderData->order_id}}</div>
        <div><span>SUPPLIER</span> {{$orderData->supplier->supplier_code}}</div>
        <div><span></span> {{$orderData->supplier->name}}</div>
        <div><span>PLACED</span> {{$orderData->created_at}}</div>
        <div><span>STATUS</span>@if($orderData->status==0) PENDING @elseif($orderData->status==1) GOODS RECEIVED <div><span></span> {{$orderData->updated_at}}</div>  @else DECLINED <div><span></span> {{$orderData->updated_at}}</div> @endif </div>
        <div><span>CURRENCY</span> Kenya Shillings</div>
    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th style="text-align:left">PRODUCT</th>
            <th style="text-align:left">SIZE</th>
            <th style="text-align:left">PACKAGING</th>
            <th style="text-align:right">UNIT COST</th>
            <th style="text-align:right">QTY</th>
            <th style="text-align:right">AMOUNT</th>

        </tr>
        </thead>
        <tbody>

        <?php $total=0;?>

        @foreach(unserialize($orderData->order_data) as $key=> $detail)
            <?php $total+=($detail['stock']*$detail['cost']);?>
            <tr>
                <td class="service">{{$detail['product_name']}}</td>
                <td class="service">{{$detail['size_name']}}</td>
                <td class="service">{{$detail['packaging']==="pack"?$detail['no_of_packs'].' '.$detail['packaging'].'(s) @ Ksh '.number_format($detail['cost_per_pack'],2).' with '.$detail['qty_in_pack'].' units per pack':'Single Unit(s)'}}</td>
                <td class="total">{{number_format($detail['cost'],2)}}</td>
                <td class="total">{{$detail['stock']}}</td>
                <td class="total">{{number_format(($detail['stock']*$detail['cost']),2)}}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <div class="project">
        <div><span>SUBTOTAL</span> {{number_format($total,2)}}</div>
        <div><span>TAX</span> 0.00</div>
        <div><span>TOTAL</span> {{number_format($total,2)}}</div>
        <div style="margin-bottom: 20px;"></div>
    </div>
    <div class="signature">
        <div><span>MANAGER SIGN</span> --------------------</div>
        <div><span>DATE</span> --------------------</div>
        <div><span>STAMP</span> --------------------</div>
    </div>
</main>
<footer>
    Purchase Order Generated by {{auth()->user()->name}} on {{(Carbon\Carbon::now())->toDayDateTimeString()}}
</footer>

</body>

</html>
