<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;


   protected $fillable = [
    'user_id', 'total_price', 'status'
];

public function user()
{
    return $this->belongsTo(User::class);
}

public function items()
{
    return $this->hasMany(OrderItem::class);
}

    public static function calculateTotalFromItems(array $items): float
    {
        $total = 0.0;
        foreach ($items as $item) {
            $qty = isset($item['quantity']) ? (float)$item['quantity'] : 0;
            $price = isset($item['price']) ? (float)$item['price'] : 0.0;
            $total += $qty * $price;
        }
        return round($total, 2);
    }

public function payment()
{
    return $this->hasOne(Payment::class);
}

}
