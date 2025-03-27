<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'address', 'phone'];

    // One Customer can have many Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // One Customer can have many items in the Wishlist
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    // One Customer can have multiple Payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // One Customer can have multiple items in Cart
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
    //
}
