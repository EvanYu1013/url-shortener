<?php

declare(strict_types=1);

use App\Http\Controllers\LinkController;
use App\Http\Controllers\RequestLogController;
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

Route::post('/request-logs', [RequestLogController::class, 'store'])->name('request_logs.store');

Route::get('/{slug}', [LinkController::class, 'show'])->name('links.show');
