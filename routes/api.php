<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\Brands\BrandController;
use App\Http\Controllers\Categories\CategoryController;
use App\Http\Controllers\Companies\CompanyController;
use App\Http\Controllers\Offers\OfferController;
use App\Http\Controllers\Offers\OfferProductController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Settings\CompanySettingsController;
use App\Http\Controllers\Settings\ContentSettingsController;
use App\Http\Controllers\Settings\SystemSettingsController;
use App\Http\Controllers\Settings\NotifySettingsController;
use App\Http\Controllers\Settings\StatusController;
use App\Imports\ProductImport;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//public route
Route::get('/', [IndexController::class, 'index'])->name('index');

Route::prefix('offer')->name('offer.')->group(function () {
    Route::get('/', [OfferController::class, 'index'])->name('index');
    Route::post('/store', [OfferController::class, 'store'])->name('store');
    Route::get('/edit/{offer}', [OfferController::class, 'edit'])->name('edit');
    Route::get('/create/{id}', [OfferController::class, 'create'])->name('create');
    Route::post('/update/{offer}', [OfferController::class, 'update'])->name('update');
    Route::post('/teklif-arama-sonuclari', [OfferController::class, 'headerSearch'])->name('search');

    Route::get('/arama-sonuclari', [OfferController::class, 'seriNoSearch'])->name('seri_no.search');
    Route::get('/barcode-arama-sonuclari', [OfferController::class, 'barcodeNoSearch'])->name('barcode_no.search');

    Route::post('/addForm', [OfferController::class, 'addForm'])->name('addForm');

});


//private route
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
