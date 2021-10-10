<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sales Invoice</title>
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
            line-height: 1.6;
        }
        .signature span {
            color: #5D6975;
            text-align: left;
            width: 90px;
            margin-right: 10px;
            display: inline-block;
            padding:2px;
            font-size: 0.8em;
            line-height: 1.6;
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
            margin-top: 40px;
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
    <h1>INVOICE</h1>

    <div class="project">
        <div><span>SUPPLIER</span> {{$invoiceFirstRowData->supplier->supplier_code}}</div>
        <div><span></span> {{$invoiceFirstRowData->supplier->name}}</div>
        <div><span>POSTAL ADDRESS</span> PO BOX {{$invoiceFirstRowData->supplier->address}}</div>
        <div><span>SUPPLIED</span> {{$invoiceFirstRowData->created_at}}</div>
        <div><span>CURRENCY</span> Kenya Shillings</div>
    </div>

    <div class="signature">
        <div><span>STORE</span> {{$invoiceFirstRowData->branch->name}}</div>
        <div><span>INVOICE ID</span> {{$invoiceFirstRowData->invoice_id}}</div>
        <div><span>FROM ORDER</span> {{$invoiceFirstRowData->order_id}}</div>
        <div><span>PAYMENT STATUS</span>{{$invoiceFirstRowData->payment_status==1?'PAID':'PENDING'}}</div>
        <div><span>{{$invoiceFirstRowData->payment_status==1?'PAID ON':'DUE BY'}}</span> {{$invoiceFirstRowData->payment_status==1?$invoiceFirstRowData->paid_on:$invoiceFirstRowData->due_on}}</div>
    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th style="text-align:left">PRODUCT</th>
            <th style="text-align:left">SIZE</th>
            <th style="text-align:left">PACKAGING</th>
            <th style="text-align:right">COST</th>
            <th style="text-align:right">QUANTITY</th>
            <th style="text-align:right">AMOUNT</th>

        </tr>
        </thead>
        <tbody>

        <?php $total=0;?>


            @foreach(unserialize($invoiceData->order_data) as $data)
            <?php $total+=($data['stock']*$data['cost']);?>
            <tr>
                <td class="service">{{\App\Models\Size::find($data['size_id'])->sku}} <br> {{$data['product_name']}}</td>
                <td class="service">{{$data['size_name']}}</td>
                <td class="service">{{$data['packaging']==="pack"?$data['no_of_packs'].' '.$data['packaging'].'(s) @ Ksh '.number_format($data['cost_per_pack'],2).' with '.$data['qty_in_pack'].' units per pack':'Single Unit(s)'}}</td>
                <td class="total">{{number_format($data['cost'],2)}}</td>
                <td class="total">{{$data['stock']}}</td>
                <td class="total">{{number_format(($data['stock']*$data['cost']),2)}}</td>
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
    Invoice Generated by {{auth()->user()->name}} on {{(Carbon\Carbon::now())->toDayDateTimeString()}}
</footer>

</body>

</html>
