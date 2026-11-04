<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_film',
        'harga',
        'studio',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
