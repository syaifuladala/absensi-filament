<?php

use App\Http\Controllers\DownloadController;
use Carbon\Carbon;
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
    return redirect('/admin');
});

Route::prefix('/clock-in')->group(function () {
    Route::get('/success', function () {
        $now = Carbon::now();
        return view('modal', ['success' => true, 'title' => 'Success Clock In', 'time' => $now->format('H:i'), 'date' => $now->format('d M Y')]);
    });
    Route::get('/failed', function () {
        return view('modal', ['success' => false, 'title' => 'Failed! Already Clock In', 'time' => '', 'date' => '']);
    });
});

Route::prefix('/clock-out')->group(function () {
    Route::get('/success', function () {
        $now = Carbon::now();
        return view('modal', ['success' => true, 'title' => 'Success Clock Out', 'time' => $now->format('H:i'), 'date' => $now->format('d M Y')]);
    });
    Route::get('/failed', function () {
        $message = 'Failed! Clock In First';
        if ((bool) request()->input('clock_in')){
            $message = 'Failed! Already Clock Out';
        };
        return view('modal', ['success' => false, 'title' => $message, 'time' => '', 'date' => '']);
    });
});

Route::get('/download/{model}', [DownloadController::class, 'getDownload']);