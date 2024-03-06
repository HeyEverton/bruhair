<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'avg_price',
    ];

    protected $appends = [
        'price_formatted',
    ];

    public function priceFormatted(): Attribute
    {
        return new Attribute(
            get: fn() => 'R$ ' . number_format($this->avg_price, 2, ',', '.')
        );
    }
}
