<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', function () {
    return view('billing');
});

Route::post('/invoice', function (Request $request) {
    return view('invoice', [
        'data' => $request->all(),
    ]);
});
