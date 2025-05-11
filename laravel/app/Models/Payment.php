<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['payment_date', 'payment_method', 'amount', 'order_id', 'customer_id'];

    // A Payment belongs to one Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // A Payment belongs to one Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    //
}
