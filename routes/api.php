<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Tds;
use App\Models\Ultrasonic;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Routes ini akan digunakan untuk pengambilan data sensor via endpoint API.
|
*/

// Route default user login (boleh tetap jika pakai auth)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ✅ Ambil data TDS terbaru
Route::get('/tds/latest', function () {
    return response()->json(
        Tds::orderBy('created_at', 'desc')->first()
    );
});

// ✅ Ambil data Ultrasonic terbaru
Route::get('/ultrasonic/latest', function () {
    return response()->json(
        Ultrasonic::orderBy('created_at', 'desc')->first()
    );
});
