<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Purchase Return Statement</title>
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
        <h1>PURCHASES RETURN REPORT</h1>

        <div class="project">
            <div><span>STORE</span> {{$branch}}</div>
            <div><span>FROM DATE</span> {{$from}}</div>
            <div><span>TO DATE</span> {{$to}}</div>
            <div><span>CURRENCY</span> Kenya Shillings</div>
        </div>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th class="cpt_no">DATE</th>
                    <th class="cpt_no">INVOICE</th>
                    <th class="cpt_no">NAME</th>
                    <th class="cpt_no">SIZE</th>
                    <th class="cpt_no">QTY</th>
                    <th class="cpt_no">UNIT COST</th>
                    <th class="cpt_no">AMOUNT</th>
                </tr>
            </thead>
            <tbody>

            <?php $totalcost=0;?>

            <?php $GrandTotal=0;?>
            @foreach($purchases as $purchase)
                @foreach(unserialize($purchase->order_data) as $data)
                    <?php $GrandTotal+=$data['cost']*$data['stock'];?>

                    <tr>
                        <td class="service">{{($purchase->created_at)}}</td>
                        <td class="service">{{$purchase->invoice_id}}</td>
                        <td class="service">{{\App\Models\Size::find($data['size_id'])->sku}} </br> {{$data['product_name']}}</td>
                        <td class="service">{{$data['size_name']}}</td>
                        <td class="total">{{$data['stock']}}</td>
                        <td class="total">{{number_format($data['cost'],2)}}</td>
                        <td class="total">{{number_format(($data['cost']*$data['stock']),2)}}</td>

                        </td>

                    </tr>

                @endforeach
            @endforeach

            </tbody>
        </table>
        <div class="project">
            <div><span>TOTAL COST</span> {{number_format($GrandTotal,2)}}</div>
        </div>
    </main>
    <footer>
        Purchase Return Statement Generated by {{auth()->user()->name}} on {{(Carbon\Carbon::now())->toDayDateTimeString()}}
    </footer>

</body>

</html>
