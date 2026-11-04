<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_harga',
        'status',
    ];

    // Tambahkan relasi ke User (ini yang kurang tadi)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Tambahkan relasi ke OrderDetail
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
