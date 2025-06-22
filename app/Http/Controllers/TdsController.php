<?php

namespace App\Http\Controllers;

use App\Models\Tds;
use App\Models\Ultrasonic;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $latestTds = Tds::latest()->first();
        $latestUltrasonic = Ultrasonic::latest()->first();

        return view('dashboard', compact('latestTds', 'latestUltrasonic'));
    }

    public function history()
    {
        $tdsHistory = Tds::orderBy('created_at', 'desc')->paginate(20);
        $ultrasonicHistory = Ultrasonic::orderBy('created_at', 'desc')->paginate(20);

        return view('history', compact('tdsHistory', 'ultrasonicHistory'));
    }
}

