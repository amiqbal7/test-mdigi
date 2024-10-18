<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'daily_transactions';

    protected $fillable = [
        'data_rekening_id',
        'payment_via',
        'deposit_date',
        'payment_amount',
    ];

    public function rekening() {
        return $this->belongsTo(Rekening::class, 'data_rekening_id');
    }

}
