<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'customer_id'];

    // Wishlist belongs to one Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Wishlist belongs to one Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    //
}
