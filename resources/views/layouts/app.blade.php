<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from codedthemes.com/demos/admin-templates/mash-able/dark/menu-horizontal-icon-fixed.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Mar 2021 17:47:55 GMT -->

<head>
    <title>Easy POS | Cashier</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#">
    <meta name="keywords" content="Flat ui, Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/theme.min.css')}}" rel="stylesheet" type="text/css" />

    <style type="text/css">
        /* This is what we are focused on */
        .table-wrapper {
            overflow-y: auto;
            height: 60vh;
        }

        .user_products_and_pay_card {
            height: 500px;
        }

        .table-wrapper th {
            position: sticky;
            top: 0;
            /*background: #ddd;*/
        }

        .btn-grad {
            margin: 10px;
            padding: 15px 36px;
            text-align: center;
            text-transform: uppercase;
            transition: .5s;
            background-size: 200% auto;
            color: #fff;
            box-shadow: 0 0 20px #eee;
            border-radius: 10px;
            display: block;
            outline: none;
        }

        .wrap-input100 {
            width: 100%;
            position: relative;
            margin-bottom: 37px;
            border-bottom: 2px solid transparent;
            border-image: linear-gradient(to right, rgb(67, 206, 162) 0%, rgb(24, 90, 157) 51%, rgb(67, 206, 162) 100%);
            border-image-slice: 1;
        }

        /* A bit more styling to make it look better */

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th {
            /*background: #DDD;*/
        }

        td,
        th {
            padding: 10px;
        }

        th .sub-text {
            text-transform: uppercase;
            ;
        }



        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
            /*font-size: 20px;*/
        }

        @media print {
            .page-break {
                display: block;
                page-break-before: always;
            }
        }

        /* Dropdown Content (Hidden by Default) */
        .dropdown-content {
            position: absolute;
            /*background-color: #f6f6f6;*/
            min-width: 250px;
            z-index: 1;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
            display: block;
            padding: 12px 16px;
            text-decoration: none;
            background: #EEE6FD;
        }

        /* width */
        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #34495e;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #34495e;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
    @livewireStyles
</head>
<!-- Menu horizontal icon fixed -->

<body>




    {{$slot}}

    @include('modals.successCashSalePlacedModal')
    @include('modals.PrinterNotConnectedModal')
    @include('modals.OutOfStockModal')
    @include('modals.ProductCodeErrorModal')
    @include('modals.CashExceedsTotalErrorModal')
    @include('modals.NoAddedProductsErrorModal')
    @include('modals.NoActiveBillToHoldErrorModal')
    @include('modals.BillHeldModal')
    @include('modals.ReleaseSuspendedBillModal')
    @include('modals.NoBillInSessionErrorModal')
    @include('modals.BillAlreadySuspendedErrorModal')
    @include('modals.CashPaymentErrorModal')
    @include('modals.SuccessReprintingReceiptModal')
    @include('modals.TillNotAssignedErrorModal')



    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/waves.js')}}"></script>
    <script src="{{asset('assets/js/simplebar.min.js')}}"></script>
    <link href="{{asset('plugins/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Morris Js-->
    <script src="{{asset('plugins/morris-js/morris.min.js')}}"></script>

    <!-- Raphael Js-->
    <script src="{{asset('plugins/raphael/raphael.min.js')}}"></script>

    <!-- Morris Custom Js-->
    <script src="{{asset('assets/pages/dashboard-demo.js')}}"></script>


    <script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>

    <!-- Sweet Alerts Js-->
    <script src="{{asset('assets/pages/sweet-alert-demo.js')}}"></script>


    <!-- App js -->
    <script src="{{asset('assets/js/theme.js')}}"></script>
    <script>
        function ifEmpty() {
            $(document).on('keyup', '#searchProduct', function() {
                if ($('#searchProduct').val() === "") {
                    $('#attributesResults').empty();
                }
            });
        }
    </script>
    <script>
        // window.addEventListener('ScrollProductsTableToBottomEvent', event => {
        //     // var rowpos = $('.table tr:last').position();
        //     $('.table-wrapper').scrollTop();
        // })
    </script>
    <script>
        window.addEventListener('MessageAlertEvent', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-center',
            });
        })
    </script>
    <script>
        window.addEventListener('ModalSuccessOrderAlertEvent', event => {
            Swal.fire({
                type: 'success',
                width: 250,
                title: 'Success!',
                text: 'Sale Completed',
            })
        })
    </script>
    <script>
        window.addEventListener('viewTransactionSummaryModalEvent', event => {
            $("#TransactionsSummaryModal").modal('show');
        })
    </script>
    <script>
        window.addEventListener('ProductSelectedModalEvent', event => {
            $("#ProductSelectedModal").modal('show');
        })
    </script>
    <script>
        window.addEventListener('DismissReprintingReceiptModalEvent', event => {
            $("#DismissReprintingReceiptModal").modal('show');
        })
    </script>
    <script>
        window.addEventListener('CashPaymentErrorEvent', event => {
            $("#CashPaymentErrorModal").modal('show');
        })
    </script>
    <script>
        window.addEventListener('SuccessReprintingReceiptModalEvent', event => {
            $("#SuccessReprintingReceiptModal").modal('show');
        })
    </script>
    <script>
        window.addEventListener('CloseReprintReceiptModalEvent', event => {
            $("#ReprintReceiptModal").modal('hide');
        })
    </script>
    <script>
        window.addEventListener('ReprintReceiptModalEvent', event => {
            $("#ReprintReceiptModal").modal('show');
        })
    </script>
    <script>
        window.addEventListener('ReleaseSuspendedBillEvent', event => {
            $("#ReleaseSuspendedBillModal").modal('show');
        })
    </script>
    <script>
        window.addEventListener('NoBillInSessionErrorEvent', event => {
            $("#NoBillInSessionErrorModal").modal('show');
        })
    </script>
    <script>
        window.addEventListener('BillAlreadySuspendedErrorEvent', event => {
            $("#BillAlreadySuspendedErrorModal").modal('show');
        })
    </script>
    <script>
        window.addEventListener('NoActiveBillToHoldErrorEvent', event => {
            $("#NoActiveBillToHoldErrorModal").modal('show');
        })
    </script>
    <script>
        window.addEventListener('BillHeldEvent', event => {
            $("#BillHeldModal").modal('show');
        })
    </script>
    <script>
        window.addEventListener('ConfirmRemoveItemFromPOSModalEvent', event => {
            $("#ConfirmRemoveItemFromPOSModal").modal('show');
        })
    </script>
    <script>
        window.addEventListener('CloseRemoveItemFromPOSModalEvent', event => {
            $("#ConfirmRemoveItemFromPOSModal").modal('hide');
        })
    </script>
    <script>
        window.addEventListener('ModalIPPrinterNotConnectedEvent', event => {
            $("#PrinterNotConnectedModal").modal('show');
        })
    </script>
    <script>
        window.addEventListener('CloseDepositsModalEvent', event => {
            $("#viewDepositsModal").modal('hide');
        })
    </script>

    <script>
        window.addEventListener('viewChangePasswordModalEvent', event => {
            $("#changePasswordModal").modal('show');
        })
    </script>
    <script>
        window.addEventListener('NoAddedProductsErrorModalEvent', event => {
            $("#NoAddedProductsErrorModal").modal('show');
        })
    </script>
    <script>
        window.addEventListener('OutOfStockEvent', event => {
            $("#OutOfStockModal").modal('show');
        })
    </script>
    <script>
        window.addEventListener('closeChangePasswordModalEvent', event => {
            $("#changePasswordModal").modal('hide');
        })
    </script>
    <script>
        window.addEventListener('showErrorUpdatingPassword', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>
    <script>
        window.addEventListener('showEventMessage', event => {
            Swal.fire({
                type: event.detail.type,
                width: 250,                
                title: event.detail.title,
                text: event.detail.message,
            })
        })
    </script>
    <script>
        window.addEventListener('errorDeclaringAmountEvent', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>
    <script>
        window.addEventListener('successDeclaringAmountEvent', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>
    <script>
        window.addEventListener('printReceiptEvent', event => {
            // alert(event.detail.sale.id);
            print("#printable");
        })
    </script>
    <script>
        window.addEventListener('viewDepositsModalEvent', event => {
            $("#viewDepositsModal").modal("show");
        })
    </script>
    <script>
        window.addEventListener('showPaymentsModalEvent', event => {
            $("#PaymentsModal").modal("show");
        })
    </script>
    <script>
        window.addEventListener('TillNotAssignedErrorModalEvent', event => {
            $("#TillNotAssignedErrorModal").modal("show");
        })
    </script>
    <script>
        window.addEventListener('ProductCodeErrorEvent', event => {
            $("#ProductCodeErrorModal").modal("show");
        })
    </script>
    <script>
        window.addEventListener('CashExceedsTotalErrorModalEvent', event => {
            $("#CashExceedsTotalErrorModal").modal("show");
        })
    </script>
    <script>
        window.addEventListener('hidePaymentsModalEvent', event => {
            $("#PaymentsModal").modal("hide");
        })
    </script>
    <script>
        window.addEventListener('viewOpenCashDrawerModal', event => {
            $("#viewOpenCashDrawerModal").modal("show");
        })
    </script>
    <script>
        window.addEventListener('hideCashDrawerModal', event => {
            $("#viewOpenCashDrawerModal").modal("hide");
        })
    </script>
    <script>
        window.addEventListener('errorOpeningCashDrawerEvent', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>

    <script>
        window.addEventListener('showCloseShiftModalEvent', event => {
            $("#closeShiftModal").modal("show");
        })
    </script>
    <script>
        window.addEventListener('ShowSearchModalEvent', event => {
            $("#ShowSearchModal").modal("show");
        })
    </script>
    <script>
        window.addEventListener('hideCloseShiftModalEvent', event => {
            $("#closeShiftModal").modal("hide");
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>
    <script>
        window.addEventListener('shiftClosedEvent', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>
    <script>
        window.addEventListener('PrintReceiptEvent', event => {
            loadOtherPage()
        })

        function loadOtherPage() {
            $("<iframe>") // create a new iframe element
                .hide() // make it invisible
                .attr("src", "/thermal/receipt/view") // point the iframe to the page you want to print
                .appendTo("body"); // add iframe to the DOM to cause it to load the page
        }
    </script>
    @livewireScripts

</body>

</html>