<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ultrasonic extends Model
{
    // Sesuaikan nama tabel sesuai dengan database
    protected $table = 'ultrasonic_data';

    protected $fillable = [
        'jarak_air',
        'status_air',
        'pompa_air',
    ];

    public $timestamps = true; // aktifkan jika tabel punya created_at & updated_at
}
