<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi melalui mass assignment.
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_type',
        'discount_amount',
        'stock',
        'image',
        'is_best_seller',
        'is_active',
        'is_available',
    ];

    /**
     * Menghitung harga akhir berdasarkan diskon
     */
    public function getFinalPriceAttribute()
    {
        if (!$this->discount_type || $this->discount_amount <= 0) {
            return $this->price;
        }

        if ($this->discount_type === 'percent') {
            return max(0, $this->price - ($this->price * ($this->discount_amount / 100)));
        }

        if ($this->discount_type === 'fixed') {
            return max(0, $this->price - $this->discount_amount);
        }

        return $this->price;
    }

    /**
     * Casting tipe data agar konsisten sebagai boolean.
     */
    protected $casts = [
        'is_best_seller' => 'boolean',
        'is_active'      => 'boolean',
        'is_available'   => 'boolean',
    ];

    /**
     * Relasi ke model Category (Satu menu punya satu kategori).
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke model OrderItem (Satu menu bisa ada di banyak detail pesanan).
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}