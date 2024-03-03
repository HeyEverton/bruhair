<?php

namespace App\Services;
use App\Base\BaseService;
use App\Models\Product;
use App\Models\User;

class ProductService extends BaseService
{
    public function __construct(private Product $product)
    {
        parent::__construct($product);
    }
}
