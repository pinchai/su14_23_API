<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KhqrController;

Route::post('/generate-qrcode', [KhqrController::class, 'generateQRCode']);
Route::post('/checkQRCode', [KhqrController::class, 'checkTransactionByMD5']);
