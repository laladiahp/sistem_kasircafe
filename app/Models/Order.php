<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_PREPARING = 'preparing';
    public const STATUS_SERVED = 'served';
    public const STATUS_PAID = 'paid';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'order_number',
        'table_number',
        'customer_name',
        'status',
        'total',
        'notes',
        'payment_method',
        'paid_amount',
        'change_amount',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getQueuePositionAttribute()
    {
        return self::where('status', self::STATUS_PENDING)
            ->where('created_at', '<=', $this->created_at)
            ->count();
    }
}
