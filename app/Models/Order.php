<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code',
        'customer_name',
        'total_price',
        'payment_method',
        'paid_amount',
        'change_amount',
        'discount',
        'discount_type',
        'discount_value',
        'status',
        'notes',
    ];

    /**
     * Relasi ke OrderItem (Satu pesanan memiliki banyak item produk)
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}