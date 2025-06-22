<?php

namespace App\Http\Controllers;

use App\Models\Ultrasonic;
use Illuminate\Http\Request;

class UltrasonicController extends Controller
{
    // Tampilkan data ultrasonic terbaru
    public function index()
    {
        $data = Ultrasonic::orderBy('created_at', 'desc')->take(10)->get(); // ambil 10 data terbaru
        return view('ultrasonic.index', compact('data'));
    }
}
