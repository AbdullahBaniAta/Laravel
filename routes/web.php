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

Route::group(['prefix' => 'zain-report', 'as' => 'report.'], function () {
    Route::get('/', [App\Http\Controllers\ReportController::class, 'index'])->name('index');
    Route::get('fetch', [App\Http\Controllers\ReportController::class, 'report'])->name('fetch-report-data');
});

Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
    Route::get('pos-statement', [App\Http\Controllers\ReportsController::class, 'viewPosStatement'])->name('pos-statement-view');
    Route::post('pos-statement', [App\Http\Controllers\ReportsController::class, 'downloadPosStatement'])->name('pos-statement-download');
});

Route::get('/test', function () {
    return \App\Services\ChartService::getIsTargetAchieved();
});
