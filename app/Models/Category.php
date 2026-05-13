<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
        use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    /**
     * Menggunakan slug untuk pencarian route model binding.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
