<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="/">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>Easy POS | Admin</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{asset('/admin/assets/css/dashlite.css?ver=2.2.0')}}">
    <link id="skin-default" rel="stylesheet" href="{{asset('/admin/assets/css/theme.css?ver=2.2.0')}}">

    <style type="text/css">
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
         .project {
             float: right;
             margin-bottom: 15px;
         }

        .project span {
            color: #5D6975;
            text-align: right;
            width: 100%;
            margin-right: 10px;
            display: inline-block;
            padding:2px;
            font-size: 0.8em;
        }

    </style>
    <link rel="manifest" href="/manifest2.json">
    @livewireStyles
</head>

<body class="nk-body bg-lighter npc-default has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <livewire:admin-side-bar-component>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <livewire:admin-nav-bar-component>
                <!-- main header @e -->
                <!-- content @s -->
                {{ $slot }}
                <!-- content @e -->
                <!-- footer @s -->
{{--                <livewire:admin-footer-component>--}}
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="{{asset('/admin/assets/js/bundle.js?ver=2.2.0')}}"></script>
    <script src="{{asset('/admin/assets/js/scripts.js?ver=2.2.0')}}"></script>
    <script src="{{asset('/admin/assets/js/charts/chart-ecommerce.js?ver=2.2.0')}}"></script>
    <script type="text/javascript">
        if ('serviceWorker' in navigator) {
          window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js').then(function(registration) {
              // Registration was successful
              console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) {
              // registration failed :(
              console.log('ServiceWorker registration failed: ', err);
            });
          });
        }
  </script>
    <script>
    $(document).ready(function(){
            var Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            });


        window.addEventListener('showCategoryModal', event => {
            $('#addEditCategoryModal').modal('show');
        })

        window.addEventListener('hideCategoryModal', event => {
            $('#addEditCategoryModal').modal('hide');
            Toast.fire({
                icon: 'success',
                title: event.detail.message
            })
        })
        window.addEventListener('showSubcategoryModal', event => {
            $('#addEditSubcategoryModal').modal('show');
        })
        window.addEventListener('hideSubcategoryModal', event => {
            $('#addEditSubcategoryModal').modal('hide');
            Toast.fire({
                icon: 'success',
                title: event.detail.message
            })
        })
        window.addEventListener('showProductModal', event => {
            $('#addEditProductModal').modal('show');
        })
        window.addEventListener('showSizeModal', event => {
            $('#addEditSizeModal').modal('show');
        })
        window.addEventListener('hideSizeModal', event => {
            $('#addEditSizeModal').modal('hide');
            Toast.fire({
                icon: 'success',
                title: event.detail.message
            })
        })
        window.addEventListener('hideProductModal', event => {
            $('#addEditProductModal').modal('hide');
            Toast.fire({
                icon: 'success',
                title: event.detail.message
            })
        })
        window.addEventListener('openSuccessProductModal', event => {
            $('.successCreateProductModal').modal('show');
        })
        window.addEventListener('showSupplierModal', event => {
            $('#addEditSupplierModal').modal('show');
        })
        window.addEventListener('hideSupplierModal', event => {
            $('#addEditSupplierModal').modal('hide');
            Toast.fire({
                icon: 'success',
                title: event.detail.message
            })
        })


        window.addEventListener('showBranchModal', event => {
            $('#addEditBranchModal').modal('show');
        })
        window.addEventListener('hideBranchModal', event => {
            $('#addEditBranchModal').modal('hide');
            Toast.fire({
                icon: 'success',
                title: event.detail.message
            })
        })
        window.addEventListener('showSuccessEvent', event => {
            Toast.fire({
                icon: 'success',
                title: event.detail.message
            })
        })
        window.addEventListener('showSaleReversalErrorModal', event => {
            Toast.fire({
                icon: 'error',
                title: event.detail.message
            })
        })
        window.addEventListener('showCashierModal', event => {
            $('#addEditCashiersModal').modal('show');
        })

        window.addEventListener('ShowUserLogsModal', event => {
            $("#ShowUserLogsModal").modal('show');
        })

        window.addEventListener('ShowDateRangeModalEvent', event => {
            $('#ShowDateRangeModal').modal('show');
        })
        window.addEventListener('hideCashierModal', event => {
            $('#addEditCashiersModal').modal('hide');
            Toast.fire({
                icon: 'success',
                title: event.detail.message
            })
        })

        window.addEventListener('showAdminModal', event => {
            $('#addEditAdminModal').modal('show');
        })
        window.addEventListener('hideAdminModal', event => {
            $('#addEditAdminModal').modal('hide');
            Toast.fire({
                icon: 'success',
                title: event.detail.message
            })
        })

        window.addEventListener('ErrorUpdatingAdmin', event => {
            Toast.fire({
                icon: 'error',
                title: event.detail.message
            })
        })

        window.addEventListener('showSaleReversalModal', event => {
            $('#saleReversalModal').modal('show');
        })
        window.addEventListener('hideSaleReversalModal', event => {
            $('#saleReversalModal').modal('hide');
            Toast.fire({
                icon: 'success',
                title: event.detail.message
            })
        })
         window.addEventListener('showPurchaseCancelModal', event => {
            $('#purchaseCancelModal').modal('show');
        })
        window.addEventListener('hidePurchaseCancelModal', event => {
            $('#purchaseCancelModal').modal('hide');
            Toast.fire({
                icon: 'success',
                title: event.detail.message
            })
        })
        window.addEventListener('failedCancelPurchaseEvent', event => {
            Toast.fire({
                icon: 'error',
                title: event.detail.message
            })
        })


    })
    </script>
        <script>
        window.addEventListener('settingsUpdated', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
              position: 'top-right',
            });
        })
    </script>

    <script>
        window.addEventListener('errorCreatingDiscountEvent', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>
    <script>
        window.addEventListener('successCreatingDiscountEvent', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>
    <script>
        window.addEventListener('alreadyExistingDiscountEvent', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>
    <script>
        window.addEventListener('successCancellingDiscountEvent', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>
    <script>
        window.addEventListener('showErrorEvent', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>
    <script>
        window.addEventListener('successCreatingInvoiceEvent', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>

    <script>
        window.addEventListener('successUpdatingPassword', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
              position: 'top-right',
            });
        })
    </script>

        <script>
        window.addEventListener('showNewTerminalModalEvent', event => {
            $('#addEditTerminalModal').modal('show');
        })
    </script>

    <script>
        window.addEventListener('showCheckCashierDepositModalEvent', event => {
            $('#adminCashierDepositModal').modal('show');
        })
    </script>
    <script>
        window.addEventListener('showTaxModalEvent', event => {
            $('#TaxModal').modal('show');
        })
    </script>

        <script>
        window.addEventListener('TerminalUpdated', event => {

            NioApp.Toast(event.detail.message, event.detail.type, {
              position: 'top-right',
            });
            $('#addEditTerminalModal').modal('hide');
        })
    </script>

    <script>
        window.addEventListener('successDecisoningDepositEvent', event => {
            $('#adminCashierDepositModal').modal('hide');
        })
    </script>
    <script>
        window.addEventListener('showFloatModalEvent', event => {
            $('#adminFloatModal').modal('show');
        })
    </script>
    <script>
        window.addEventListener('AdminNewPurchaseOrderModalEvent', event => {
            $('#AdminNewPurchaseOrderModal').modal('show');
        })
    </script>
    <script>
        window.addEventListener('AdminViewSupplierAccountModalEvent', event => {
            $('#AdminViewSupplierAccountModal').modal('show');
        })
    </script>
    <script>
        window.addEventListener('SuccessAddingProductToOrderModalEvent', event => {
            $('#SuccessAddingProductToOrderModalEvent').modal('show');
        })
    </script>
    <script>
        window.addEventListener('ReprintNotAllowedForReversedSaleModalEvent', event => {
            $('#ReprintNotAllowedForReversedSale').modal('show');
        })
    </script>
    <script>
        window.addEventListener('messageSavingFloatEvent', event => {
            $('#adminFloatModal').modal('hide');
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>
    <script>
        window.addEventListener('showDiscountModal', event => {
            $('#discountModal').modal('show');
        })
    </script>
    <script>
        window.addEventListener('hideDiscountModal', event => {
            $('#discountModal').modal('hide');
        })
    </script>
    <!-- DATE PICKER -->
    <script type="text/javascript">
      $(document).ready(function(){
        $('#startingDate').on('change.date-picker',function(e){
            let dateFrom=$('#startDateDiv').data('startdate');
            eval(dateFrom).set('date_from',$('#startingDate').val())
        })
        $('#endingDate').on('change.date-picker',function(e){
            let dateTo=$('#endDateDiv').data('enddate');
            eval(dateTo).set('date_to',$('#endingDate').val())
        })
          $('#reportDateFrom').on('change.date-picker',function(e){
              let dateFrom=$('#startReportDateDiv').data('reportstartdate');
              eval(dateFrom).set('report_date_from',$('#reportDateFrom').val())
          })
          $('#reportDateTo').on('change.date-picker',function(e){
              let dateFrom=$('#endReportDateDiv').data('reportenddate');
              eval(dateFrom).set('report_date_to',$('#reportDateTo').val())
          })
      })
    </script>
    <script>
        window.addEventListener('successOpeningShiftEvent', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>
    <script>
        window.addEventListener('successClosingShiftEvent', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>
    <script>
        window.addEventListener('showAdminNonMatchingPasswordError', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>
    <script>
        window.addEventListener('showAdminWrongOldPasswordError', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>
    <script>
        window.addEventListener('showAdminSuccessUpdatingPassword', event => {
            NioApp.Toast(event.detail.message, event.detail.type, {
                position: 'top-right',
            });
        })
    </script>
    <script>
        window.addEventListener('showSaleModalEvent', event => {
            $('#adminShowSaleModal').modal('show');
        })
    </script>
    <script>
        window.addEventListener('ShowSupplierSelectModalEvent', event => {
            $('#AdminSelectSupplierModal').modal('show');
        })
    </script>
    <script>
        window.addEventListener('HideSupplierSelectModalEvent', event => {
            $('#AdminSelectSupplierModal').modal('hide');
        })
    </script>
    <script>
        window.addEventListener('ShowBranchSelectModalEvent', event => {
            $('#AdminSelectBranchModal').modal('show');
        })
    </script>
    <script>
        window.addEventListener('HideBranchSelectModalEvent', event => {
            $('#AdminSelectBranchModal').modal('hide');
        })
    </script>
    <script>
        window.addEventListener('ShowInvoicePayModalEvent', event => {
            $('#InvoicePayModal').modal('show');
        })
    </script>
    <script>
        window.addEventListener('HideInvoicePayModalEvent', event => {
            $('#InvoicePayModal').modal('hide');
        })
    </script>
    <script>
        window.addEventListener('ShowInvoiceViewModalEvent', event => {
            $('#InvoiceViewModal').modal('show');
        })
    </script>
    <script>
        window.addEventListener('ShowCashierSalesModalEvent', event => {
            $('#ViewCashierSalesModal').modal('show');
        })
    </script>
    <script>
        window.addEventListener('ViewSupplierHistoryModalEvent', event => {
            $('#SupplierHistoryModal').modal('show');
        })
    </script>
    <script>
        window.addEventListener('ShowOrderActionModalEvent', event => {
            $('#OrderActionModal').modal('show');
        })
    </script>
    <script>
        window.addEventListener('HideOrderActionModalEvent', event => {
            $('#OrderActionModal').modal('hide');
        })
    </script>
    <script>
        window.addEventListener('ShowOrderViewModalEvent', event => {
            $('#OrderViewModal').modal('show');
        })
    </script>
    <script>
        window.addEventListener('HideOrderViewModalEvent', event => {
            $('#OrderViewModal').modal('hide');
        })
    </script>
    <script>
        window.addEventListener('ViewPendingInvoiceModalEvent', event => {
            $('#ViewPendingInvoiceModal').modal('show');
        })
    </script>
    <script>
        window.addEventListener('ViewPendingOrdersModalEvent', event => {
            $('#ViewPendingOrdersModal').modal('show');
        })
    </script>
    @livewireScripts
</body>

</html>
