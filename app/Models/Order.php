<?php
// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;

// class Order extends Model
// {
//     protected $fillable = ['user_id', 'subtotal', 'status', 'meta'];

//     protected $casts = [
//         'meta' => 'array',
//     ];

//     public function items(): HasMany
//     {
//         return $this->hasMany(OrderItem::class);
//     }

//     public function user(): BelongsTo
//     {
//         return $this->belongsTo(\App\Models\User::class);
//     }
// }




namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'subtotal',
        'status',
        'payment_method',
        'payment_status',
        'transaction_id',
        'payment_details',
        'meta'
    ];

    protected $casts = [
        'meta' => 'array',
        'payment_details' => 'array',
        'subtotal' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper method to check if order was paid with MPESA
    public function isMpesaPayment()
    {
        return $this->payment_method === 'mpesa';
    }

    // Helper method to check if payment was successful
    public function isPaid()
    {
        return $this->payment_status === 'completed';
    }
    // Helper method for unique id
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            $order->order_number = 'FLQ' . now()->format('YmdHis') . strtoupper(substr(uniqid(), -4));
        });
    }
}
