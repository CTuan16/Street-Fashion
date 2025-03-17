<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'order';
    protected $primaryKey = 'id';
    protected $fillable = [
        'order_code',
        'user_id',
        'order_status_id',
        'payment_id',
        'total_amount',
        'voucher_id',
        'address',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function orderDetails()
{
    return $this->hasMany(OrderDetail::class, 'order_id');
}
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function orderStatus()
    {
        return $this->belongsTo(Status::class, 'order_status_id');
    }
    public function payment()
{
    return $this->belongsTo(Payment::class,'payment_id');
}
    public function voucher()
{
    return $this->belongsTo(Voucher::class,'voucher_id');
}

}
