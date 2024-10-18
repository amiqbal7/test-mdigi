<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $table = 'master_data_targets';

    protected $fillable = [
        'data_rekening_id',
        'target',
        'validity_period_start',
        'validity_period_end',
    ];

    public function rekening() {
        return $this->belongsTo(Rekening::class, 'data_rekening_id');
    }

}
