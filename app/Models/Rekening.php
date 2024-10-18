<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;
    protected $table = 'data_rekenings';

    protected $fillable = ['rekening_name', 'rekening_code'];

    public function targets()
    {
        return $this->hasMany(Target::class, 'data_rekening_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'data_rekening_id');
    }
}
