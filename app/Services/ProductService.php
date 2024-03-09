<?php

namespace App\Services;

use App\Base\BaseService;
use App\Models\Product;
use App\Models\User;

class ProductService extends BaseService
{
    public function __construct(private readonly Product $product)
    {
        parent::__construct($product);
    }

    public function index(array $options = [])
    {
        return [
            'data' => $this->product
                ->limit(500)
                ->get()
        ];
    }

    public function create(array $payload, string $shouldReturnResource = 'no_return'): int | object
    {
        $price = str_replace(',', '.', $payload['avg_price']);
        $price = str_replace('R$', '', $price);
        $price = str_replace(' ', '', $price);
        $payload['avg_price'] = $price;
        if ($shouldReturnResource && $shouldReturnResource == 'return_resource') {
            return $this->product->create($payload);
        }
        return 201;
    }

    public function update(array $payload, string $id)
    {
        $record = $this->show($id);
        $price = str_replace(',', '.', $payload['avg_price']);
        $price = str_replace('R$', '', $price);
        $price = str_replace(' ', '', $price);
        $payload['avg_price'] = $price;
        $record->update($payload);
    }

    public function list()
    {
        return $this->product->all();
    }
}
