<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    // 1) Add 'size_id' to fillable.
    protected $fillable = [
        'user_id',
        'quantity',
        'product_id',
        'size_id',
    ];

    // 2) Optional: Relationship to Size model
    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}

