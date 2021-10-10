<?php

use App\Http\Controllers\UsersExportController;
use App\Http\Livewire\AdminCashierReconcileComponent;
use App\Http\Livewire\AdminChangePasswordComponent;
use App\Http\Livewire\AdminDiscountComponent;
use App\Http\Livewire\AdminEodReconcileComponent;
use App\Http\Livewire\AdminInvoiceComponent;
use App\Http\Livewire\AdminOrderComponent;
use App\Http\Livewire\AdminPriceComponent;
use App\Http\Livewire\AdminPurchaseOrdersComponent;
use App\Http\Livewire\AdminReconciliationComponent;
use App\Http\Livewire\AdminRunningStockComponent;
use App\Http\Livewire\AdminSupplierHistoryComponent;
use App\Http\Livewire\AdminUnitSalesReportComponent;
use App\Http\Livewire\AdminUsersComponent;
use App\Models\Order;
use App\Services\BarcodeGenerateService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\PosHomeComponent;
use App\Http\Livewire\PosPersonalDetailsComponent;
use App\Http\Livewire\AdminHomeComponent;
use App\Http\Livewire\AdminCategoryComponent;
use App\Http\Livewire\AdminProductComponent;
use App\Http\Livewire\AdminSizeComponent;
use App\Http\Livewire\AdminSupplierComponent;
use App\Http\Livewire\AdminBranchComponent;
use App\Http\Livewire\AdminPurchaseComponent;
use App\Http\Livewire\PosLoginComponent;
use App\Http\Livewire\AdminLoginComponent;
use App\Http\Livewire\AdminSalesReportComponent;
use App\Http\Livewire\AdminStockReportComponent;
use App\Http\Livewire\AdminPurchaseReportComponent;
use App\Http\Livewire\AdminCashierReportComponent;
use App\Http\Livewire\AdminSupplierReportComponent;
use App\Http\Livewire\AdminSalesReturnsReportComponent;
use App\Http\Livewire\AdminCashierUsersComponent;
use App\Http\Livewire\AdminstratorsUsersComponent;
use App\Http\Livewire\AdminPurchasesReturnsReportComponent;
use App\Http\Livewire\AdminSettingsComponent;
use App\Http\Livewire\AdminProfitsComponent;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\Auth\LoginController;
use Milon\Barcode\DNS1D;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')->group(function() {
	Route::get('/',PosHomeComponent::class)->name('pos');
});

Route::middleware('auth:admin')->group(function() {
	Route::get('/admin/home',AdminHomeComponent::class)->name('admin.home');
	Route::get('/admin/category',AdminCategoryComponent::class)->name('admin.category')->middleware('is_admin');
	Route::get('/admin/product',AdminProductComponent::class)->name('admin.product')->middleware('is_admin');
	Route::get('/admin/size',AdminSizeComponent::class)->name('admin.size')->middleware('is_admin');
	Route::get('/admin/supplier',AdminSupplierComponent::class)->name('admin.supplier')->middleware('is_admin');
	Route::get('/supplier/statement',AdminSupplierHistoryComponent::class)->name('admin.supplier.statement')->middleware('is_admin');
	Route::get('/admin/branches',AdminBranchComponent::class)->name('admin.branches')->middleware('is_admin');
	Route::get('/admin/purchase',AdminOrderComponent::class)->name('admin.purchase')->middleware('is_admin');
	Route::get('/admin/orders',AdminPurchaseOrdersComponent::class)->name('admin.purchase.orders')->middleware('is_admin');
	Route::get('/admin/sales',AdminSalesReportComponent::class)->name('admin.sales');
	Route::get('/admin/users/cashiers',AdminCashierUsersComponent::class)->name('admin.cashier.users');
	Route::get('/administrators/users',AdminstratorsUsersComponent::class)->name('adminstrators.users')->middleware('is_admin');
	Route::get('/admin/stock',AdminStockReportComponent::class)->name('admin.stock');
	Route::get('/purchase/report',AdminPurchaseReportComponent::class)->name('admin.purchase.report');
	Route::get('/admin/cashier',AdminCashierReportComponent::class)->name('admin.cashier.report')->middleware('is_admin');
	Route::get('/supplier/report',AdminSupplierReportComponent::class)->name('supplier.report')->middleware('is_admin');
	Route::get('/sales/returns/report',AdminSalesReturnsReportComponent::class)->name('sales.returns.report');
	Route::get('/site/settings',AdminSettingsComponent::class)->name('site.settings')->middleware('is_admin');
	Route::get('/purchase/returns/report',AdminPurchasesReturnsReportComponent::class)->name('purchases.returns.report');
    Route::get('/profits/report',AdminProfitsComponent::class)->name('profits.report')->middleware('is_admin');
    Route::get('/running/stock/report',AdminRunningStockComponent::class)->name('runningStock.report');
    Route::get('/sales/discount',AdminDiscountComponent::class)->name('admin.sales.discount')->middleware('is_admin');
    Route::get('/admin/change/password',AdminChangePasswordComponent::class)->name('admin.change.password');
    Route::get('/admin/reconcile',AdminReconciliationComponent::class)->name('admin.reconciliation');
    Route::get('/cashiers/users',AdminUsersComponent::class)->name('admin.users');
    Route::get('/admin/reconcile/cashiers',AdminCashierReconcileComponent::class)->name('cashierReconciliation.report');
    Route::get('/admin/eod/reconcile',AdminEodReconcileComponent::class)->name('eodReconciliation.report');
    Route::get('/admin/invoices',AdminInvoiceComponent::class)->name('view.invoices');
    Route::get('/admin/unit/sales',AdminUnitSalesReportComponent::class)->name('unit.sales.report');
    Route::get('/admin/update/price',AdminPriceComponent::class)->name('price.update')->middleware('is_admin');
    Route::get('/shell',[UsersExportController::class, 'export']);
});


Route::get('/personal/details',PosPersonalDetailsComponent::class)->name('personal.details');


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/cashier/login', [CashierController::class,'loginForm'])->name('login');
Route::post('/cashier/login', [CashierController::class,'login'])->name('cashier.login.submit');
Route::post('/cashier/logout', [CashierController::class,'logout'])->name('cashier.logout');

Route::get('/admin/login', [AdminController::class,'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class,'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class,'logout'])->name('admin.logout');



Route::post('/api/v1/access/token', 'MpesaController@generateAccessToken');


