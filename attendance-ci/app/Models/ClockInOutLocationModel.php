<?php

namespace App\Models;

use CodeIgniter\Model;

class ClockInOutLocationModel extends Model
{
    protected $table            = 'clock_in_out_location';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'zona_waktu',
        'jam_masuk',
        'jam_keluar',
    ];
}
