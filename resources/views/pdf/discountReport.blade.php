<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Discount Report</title>
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
    <h1>DISCOUNT REPORT</h1>

    <div class="project">
        <div><span>STORE</span> {{$branch}}</div>
        <div><span>STATUS</span> {{strtoupper($status)}}</div>
        @if($status=='expired')
        <div><span>FROM DATE</span> {{$from}}</div>
        <div><span>TO DATE</span> {{$to}}</div>
        @else
            <div><span>DATE</span> {{Carbon\Carbon::now()->toDayDateTimeString()}}</div>
            @endif
        <div><span>CURRENCY</span> Kenya Shillings</div>
    </div>
</header>
<main>
    <table>
        <thead>
        <tr>
            <th class="cpt_no">PRODUCT</th>
            <th class="cpt_no">SIZE</th>
            <th class="cpt_no">RRP</th>
            <th class="cpt_no">DISC PRICE</th>
            <th class="cpt_no">CREATED</th>
            <th class="cpt_no">EXPIRY</th>
            <th class="cpt_no">COMMENT</th>
        </tr>
        </thead>
        <tbody>

        @if(!empty($reportDiscount))
            <?php $total_stock=0; ?>
            @foreach($reportDiscount as $discount)
                <?php $total_stock+=1;?>
            <tr>
                <td class="service">{{$reportDiscount?\App\models\Product::find($discount['product_id'])->name:''}}</td>
                <td class="service">{{$reportDiscount?\App\models\Size::find($discount['size_id'])->name:''}}</td>
                <td class="service">{{$reportDiscount?number_format(\App\models\ProductsAttribute::where('branch_id',$discount['branch_id'])->where('size_id',$discount['size_id'])->latest()->first()->price,2):''}}</td>
                <td class="service">{{$reportDiscount?number_format($discount['amount'],2):''}}</td>
                <td class="total">{{$reportDiscount?$discount['created_at']:''}}</td>
                <td class="total">{{$reportDiscount?$discount['expiry_date']:''}}</td>
                <td class="total">{{$reportDiscount?\Carbon\Carbon::parse($discount['expiry_date'])->diffForHumans():''}}</td>
                <!-- <td class="total">Cyrus</td> -->
            </tr>


        @endforeach
        @endif
        </tbody>
    </table>
    <div class="project">
        <div><span>COUNT. OF PRODUCTS </span> {{$total_stock}}</div>
    </div>
</main>
<footer>
    Discount Report Generated by {{auth()->user()->name}} on {{(Carbon\Carbon::now())->toDayDateTimeString()}}
</footer>

</body>

</html>
