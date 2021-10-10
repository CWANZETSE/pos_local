<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sales Receipt</title>
    <style>
        #invoice-POS {
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
            padding: 2mm;
            /*margin: 0 auto;*/
            margin: 0;
            width: 58mm;
            background: #FFF;
            font-family: monospace;
        }
        #invoice-POS ::selection {
            background: #f31544;
            color: #FFF;
        }
        #invoice-POS ::moz-selection {
            background: #f31544;
            color: #FFF;
        }
        #invoice-POS h1 {
            font-size: 1.5em;
            color: #222;
        }
        #invoice-POS h2 {
            font-size: .9em;
        }
        #invoice-POS h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }
        #invoice-POS p {
            font-size: .9em;
            color: #666;
            line-height: 1.3em;
        }
        #invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
            /* Targets all id with 'col-' */
            border-bottom: 0px solid #EEE;
        }
        #invoice-POS #top {
            min-height: 100px;
        }
        #invoice-POS #mid {
            min-height: 80px;
        }
        #invoice-POS #bot {
            min-height: 50px;
        }
        #invoice-POS #top .logo {
            height: 60px;
            width: 60px;
            background:  no-repeat;
            background-size: 60px 60px;
            margin: 0 auto;
        }
        #invoice-POS .clientlogo {
            float: left;
            height: 60px;
            width: 60px;
            background:  no-repeat;
            background-size: 60px 60px;
            border-radius: 50px;
            margin: 0 auto;
        }
        #invoice-POS .info {
            display: block;
            margin-left: 0;
        }
        #invoice-POS .title {
            float: right;
        }
        #invoice-POS .title p {
            text-align: right;
        }
        #invoice-POS table {
            width: 100%;
            border-collapse: collapse;
        }
        #invoice-POS .tabletitle {
            font-size: .9em;
            background: #EEE;
        }
        #invoice-POS .service {
            border-bottom: 0px solid #EEE;
        }
        #invoice-POS .item {
            width: 24mm;
        }
        #invoice-POS .itemtext {
            font-size: .9em;
        }
        #invoice-POS .itemamount {
            font-size: .9em;
            text-align: right;
        }
        #invoice-POS .payment{
            text-align: right;
        }
        #invoice-POS #legalcopy {
            margin-top: 5mm;
        }
        .RateTitle{
            text-align: right;
        }
        #invoice-POS .service{
            line-height: .5mm;
        }




    </style>
</head>

<body>


<div id="invoice-POS">

    <center id="top">
        <div class="logo"> </div>
        <div class="info">
            <h2>{{$storeParams['store_name']}}</h2>
            <h2>P.O BOX {{$storeParams['store_address']}}</h2>
            <small>{{$storeParams['store_phone']}}</small>
            <small>{{$storeParams['store_email']}}</small>
            <small>{{$storeParams['store_website']}}</small>
        </div><!--End Info-->
    </center><!--End InvoiceTop-->
    <div id="mid">
        <div class="info">
            <p>
                Sale: {{$sale->txn_code}}<br />
                Date: {{($sale->created_at)->toDateTimeString()}}<br />
                Store:{{strtoupper($sale->branch->name)}}<br />
            </p>
        </div>
    </div><!--End Invoice Mid-->
    <div id="bot">

        <div id="table">
            <table>
                <tr class="tabletitle">
                    <td class="item"><h2>ITEM</h2></td>
                    <td class="RateTitle"><h2>AMOUNT</h2></td>
                </tr>

                <?php $products=0; ?>
                @foreach(unserialize($sale->sale) as $order)
                    <tr class="service">
                        <td class="tableitem"><p class="itemtext">{{trim(json_encode($order['product_name']),'"')}}<br />{{trim(json_encode($order['size']),'"')}}</p></td>
                        <td class="tableitem"><p class="itemamount">{{number_format(json_encode($order['quantity']))}} x {{number_format(json_encode($order['price']),2)}}<br />{{number_format(json_encode($order['price'])*json_encode($order['quantity']),2)}}</p></td>
                    </tr>
                    <?php $products+=json_encode($order['quantity']); ?>
                @endforeach

                <tr class="tabletitle">
                    <td class="Rate"><h2>SUBTOTAL</h2></td>
                    <td class="payment"><h2>{{number_format($sale->total,2)}}</h2></td>
                </tr>
                <tr class="tabletitle">
                    <td class="Rate"><h2>TAX</h2></td>
                    <td class="payment"><h2>0.00</h2></td>
                </tr>

                <tr class="tabletitle">
                    <td class="Rate"><h2>TOTAL</h2></td>
                    <td class="payment"><h2>{{number_format($sale->total,2)}}</h2></td>
                </tr>

                <tr class="tabletitle">
                    <td class="Rate"><h2>CASH</h2></td>
                    <td class="payment"><h2>*********</h2></td>
                </tr>

                <tr class="tabletitle">
                    <td class="Rate"><h2>CHANGE</h2></td>
                    <td class="payment"><h2>**********</h2></td>
                </tr>

            </table>
        </div><!--End Table-->

        <div id="legalcopy">
            <p>--------------------------</p>
            <p class="legal">PRICES IN KSH & INCLUSIVE OF VAT WHERE APPLICABLE</p>
            <p>--------------------------</p>
            <p class="legal">YOU WERE SERVED BY: {{$sale->user->name}}</p>

        </div>

    </div><!--End InvoiceBot-->
</div><!--End Invoice-->

<script>
    window.addEventListener('printReceiptEvent', event => {
        alert('Hello from the receipt');
    })
</script>
</body>

</html>
