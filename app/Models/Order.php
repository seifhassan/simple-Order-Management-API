<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = [
        'customer_id',
        'product_name',
        'quantity',
        'price',
        'status',
    ];

    // Define relationship to Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
