<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KhqrController;

Route::get('/shop', function () {
    return view('shop.master');
});
