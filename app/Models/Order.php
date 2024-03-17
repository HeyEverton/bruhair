<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_id',
        'product_id',
        'total',
        'description',
        'payment_type',
    ];

    protected $appends = [
        'formatted_total',
        'formatted_date'
    ];


    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // public function product()
    // {
    //     return $this->belongsTo(Product::class, 'product_id');
    // }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function formattedTotal(): Attribute
    {
        return new Attribute(
            get: fn () => 'R$ ' . number_format($this->total, 2, ',', '.')
        );
    }

    public function formattedDate(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->created_at)->format('d/m/Y'),
        );
    }
}
