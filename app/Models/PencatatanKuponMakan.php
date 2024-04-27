<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PencatatanKuponMakan extends Model
{
    use HasFactory;

    protected $table = 'pencatatan_kupon_makan';

    protected $fillable = [
        'kupon_code',
        'scan_method',
        'scan_time',
    ];
}
