<?php
use App\Http\Controllers\WEB\WebIndicatorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
   return redirect('indicators-listing');
})->name('home-page');
Route::get('/chart', function () {
    // return 'ok';
    return view('chart');
});
Route::get('/line',function(){
return view('map.line_chart');
});
Route::get('/indicators-listing', [WebIndicatorController::class, 'GetAllIndicators'])->name('indicators');
Route::get('/detail_indicators/{name}/{table_name}', [WebIndicatorController::class, 'GetDetailIndicators'])->name('DetailIndicator');
require __DIR__.'/sdg.php';
