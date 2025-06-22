<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tds extends Model
{
    protected $table = 'tds_data'; // Pastikan nama tabel sesuai di database

    protected $fillable = [
        'device_id',
        'nutrisi_ppm',
        'pompa_nutrisi',
        'pompa_aliran',
        'status_nutrisi',
        'status_ideal',
    ];

    public $timestamps = true;
}
