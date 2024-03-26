<?php

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

Route::view('/', 'welcome')->middleware('auth')->name('home');
Route::post('/logout',[App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'authenticate'])->name('authenticate');

Route::group(['prefix' => 'charts', 'as' => 'charts.'], function () {
    Route::get('/', [App\Http\Controllers\ChartsController::class, 'index'])->name('index');
    Route::get('fetch-chart-data', [App\Http\Controllers\ChartsController::class, 'fetchChartData'])->name('fetch-chart-data');
});


Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
    Route::get('pos-statement', [App\Http\Controllers\ReportsController::class, 'viewPosStatement'])->name('pos-statement-view');
    Route::post('pos-statement', [App\Http\Controllers\ReportsController::class, 'downloadPosStatement'])->name('pos-statement-download');
    Route::get('balance-request', [App\Http\Controllers\ReportsController::class, 'viewBalanceRequest'])->name('balance-request-view');
    Route::post('balance-request', [App\Http\Controllers\ReportsController::class, 'downloadBalanceRequest'])->name('balance-request-download');
    Route::get('financial-transaction', [App\Http\Controllers\ReportsController::class, 'viewFinancialTransactions'])->name('financial-transaction-view');
    Route::post('financial-transaction', [App\Http\Controllers\ReportsController::class, 'downloadFinancialTransactions'])->name('financial-transaction-download');
    Route::get('pos-summary', [App\Http\Controllers\ReportsController::class, 'viewPOSSummary'])->name('post-summary-view');
    Route::post('pos-summary', [App\Http\Controllers\ReportsController::class, 'downloadPOSSummary'])->name('pos-summary-download');
});

Route::get('/test', function () {
    $x = new \App\Services\ChartService();
    $x->posStatementCharts();
});
