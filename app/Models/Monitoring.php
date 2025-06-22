<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    protected $table = 'monitoring_data'; // Sesuaikan dengan nama tabel kamu
    protected $fillable = [
        'nutrisi_ppm',
        'pompa_nutrisi',
        'pompa_aliran',
        'status_nutrisi',
        'status',
        'jarak_air',
        'pompa_air',
        'status_air'
    ];
    public $timestamps = true; // Jika pakai created_at dan updated_at
}
