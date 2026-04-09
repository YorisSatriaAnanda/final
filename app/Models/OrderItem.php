<?php

namespace App\Http\Controllers;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi melalui mass assignment.
     */
    protected $fillable = [
        'order_id',
        'menu_id',
        'qty',
        'price',
        'subtotal',
        'notes',
    ];

    /**
     * Relasi ke model Order (Item ini milik pesanan yang mana).
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi ke model Menu (Item ini merujuk ke produk/kopi yang mana).
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}