<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Sales Receipt</title>
    <style>
       #receipt {
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
            padding: 2mm;
            /*margin: 0 auto;*/
            margin: 0;
            width: 58mm;
            background: #FFF;
            font-family: Verdana;
        }
       #receipt ::selection {
            background: #f31544;
            color: #FFF;
        }
       #receipt ::moz-selection {
            background: #f31544;
            color: #FFF;
        }
       #receipt h1 {
            font-size: 1.5em;
            color: #222;
        }
       #receipt h2 {
            font-size: .9em;
        }
       #receipt h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }
       #receipt p {
            font-size: .9em;
            color: #666;
            line-height: 1.3em;
        }
       #receipt #top,#receipt #mid,#receipt #bot {
            /* Targets all id with 'col-' */
            border-bottom: 0px solid #EEE;
        }
       #receipt #top {
            min-height: 100px;
        }
       #receipt #mid {
            min-height: 80px;
        }
       #receipt #bot {
            min-height: 50px;
        }
       #receipt #top .logo {
            height: 60px;
            width: 60px;
            background-size: 60px 60px;
            margin: 0 auto;
        }
       #receipt .clientlogo {
            float: left;
            height: 60px;
            width: 60px;
            background-size: 60px 60px;
            border-radius: 50px;
            margin: 0 auto;
        }
       #receipt .info {
            display: block;
            margin-left: 0;
        }
       #receipt .title {
            float: right;
        }
       #receipt .title p {
            text-align: right;
        }
       #receipt table {
            width: 100%;
            border-collapse: collapse;
        }
       #receipt .tabletitle {
            font-size: .9em;
            background: #EEE;
        }
       #receipt .service {
            border-bottom: 0px solid #EEE;
        }
       #receipt .item {
            width: 24mm;
        }
       #receipt .itemtext {
            font-size: .9em;
        }
       #receipt .itemamount {
            font-size: .9em;
            text-align: right;
        }
       #receipt .payment{
            text-align: right;
        }
       #receipt #legalcopy {
            margin-top: 5mm;
        }
        .RateTitle{
            text-align: right;
        }
       #receipt .service{
            line-height: .5mm;
        }




    </style>
</head>

<body onLoad="self.print()">


<div id="receipt">

    <center id="top">
        <div class="logo"> </div>
        <div class="info">
            <h2>SKY TECHNOLOGIES</h2>
            <h2>P.O BOX NAIROBI</h2>
        </div><!--End Info-->
    </center><!--End InvoiceTop-->
    <div id="mid">
        <div class="info">
            <p>
                Sale: 345678<br />
                Date: 34567890<br />
                Store:4567890-<br />
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


                    <tr class="service">
                        <td class="tableitem"><p class="itemtext">23W<br />4567</p></td>
                        <td class="tableitem"><p class="itemamount">4654x 456<br />4500</p></td>
                    </tr>

                <tr class="tabletitle">
                    <td class="Rate"><h2>SUBTOTAL</h2></td>
                    <td class="payment"><h2>4567</h2></td>
                </tr>
                <tr class="tabletitle">
                    <td class="Rate"><h2>TAX</h2></td>
                    <td class="payment"><h2>0.00</h2></td>
                </tr>

                <tr class="tabletitle">
                    <td class="Rate"><h2>TOTAL</h2></td>
                    <td class="payment"><h2>5600.00</h2></td>
                </tr>

                <tr class="tabletitle">
                    <td class="Rate"><h2>CASH</h2></td>
                    <td class="payment"><h2>548.00</h2></td>
                </tr>

                <tr class="tabletitle">
                    <td class="Rate"><h2>CHANGE</h2></td>
                    <td class="payment"><h2>34.90</h2></td>
                </tr>

            </table>
        </div><!--End Table-->

        <div id="legalcopy">
            <p>--------------------------</p>
            <p class="legal">PRICES IN KSH & INCLUSIVE OF VAT WHERE APPLICABLE</p>
            <p>--------------------------</p>
            <p class="legal">YOU WERE SERVED BY: cYRSU</p>

        </div>

    </div><!--End InvoiceBot-->
</div><!--End Invoice-->


</body>

</html>
