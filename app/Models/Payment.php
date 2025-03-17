<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_id',
        'payment_status',
        'transaction_id',
        'payment_method',
        'amount',
        'note'

    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function paymentStatus()
    {
        return $this->belongsTo(Status::class, 'payment_status');
    }

}
