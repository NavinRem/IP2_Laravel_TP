<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Order extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = 'orders';

    protected function orderDate(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Carbon::parse($value)->format('Y-m-d H:i:s'),
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y H:i:s')
        );
    }
    use HasFactory;

    protected $fillable = ['order_date', 'total_price', 'customer_id'];

    // An Order belongs to one Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // An Order can have many Products (Many-to-Many)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
                    ->withPivot('price', 'quantity');
    }

    // An Order has one Payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
