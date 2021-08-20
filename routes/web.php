<?php

use App\Http\Controllers\PagoController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/comprar', [PagoController::class, 'index']);
Route::get('/', [PagoController::class, 'index']);
Route::get('/response', [PagoController::class, 'response'])->name('response');
Route::get('/paymentInformation', [PagoController::class, 'formCard']);
Route::get('/paymentInformation2', [PagoController::class, 'formCard2']);
Route::post('/savePaymentInformation', [PagoController::class, 'saveData'])->name('savePaymentInformation');
Route::post('/savePaymentInformation2', [PagoController::class, 'tokenizationDataCard'])->name('savePaymentInformation2');