<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tds;
use App\Models\Ultrasonic;

/*
|--------------------------------------------------------------------------
| ROUTE LOGIN MANUAL
|--------------------------------------------------------------------------
*/

// Tampilkan halaman login (jika belum login)
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

// Proses login
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
})->name('login.submit');

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| ROUTE UNTUK FRONTEND (HARUS LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Redirect root ke dashboard
    Route::get('/', function () {
        return redirect('/dashboard');
    });

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Riwayat Monitoring
    Route::get('/history', function () {
        $tdsData = Tds::orderBy('created_at', 'desc')->limit(100)->get();
        $ultrasonicData = Ultrasonic::orderBy('created_at', 'desc')->limit(100)->get();

        return view('history', compact('tdsData', 'ultrasonicData'));
    })->name('history');

    // Hapus semua riwayat monitoring
    Route::delete('/history/delete-all', function () {
        DB::table('tds_data')->truncate();
        DB::table('ultrasonic_data')->truncate();

        return redirect()->route('history')->with('success', 'Data riwayat berhasil dihapus!');
    })->name('history.deleteAll');

    // Profil
    Route::get('/profil', function () {
        return view('profil');
    })->name('profil');
});

/*
|--------------------------------------------------------------------------
| ROUTE API (TIDAK PERLU LOGIN)
|--------------------------------------------------------------------------
*/

Route::get('/api/tds/latest', fn () => response()->json(Tds::latest()->first()));
Route::get('/api/ultrasonic/latest', fn () => response()->json(Ultrasonic::latest()->first()));

Route::get('/api/tds/history', fn () => response()->json(Tds::latest()->get()));
Route::get('/api/ultrasonic/history', fn () => response()->json(Ultrasonic::latest()->get()));
