<?php

namespace App\Services;

use App\Base\BaseService;
use App\Models\Order;
use Illuminate\Http\Response;

class OrderService extends BaseService
{
    public function __construct(private Order $order)
    {
        parent::__construct($order);
    }

    public function create(array $payload, string $shouldReturnResource = 'no_return'): int | object
    {
        $payload['user_id'] = auth()->user()->id;
        $payload['total'] = str_replace(',', '.', $payload['total']);
        $payload['total'] = str_replace('R$', '', $payload['total']);
        $payload['total'] = str_replace(' ', '', $payload['total']);
        $order = $this->order->create($payload);
        if ($shouldReturnResource === 'return_resource') {
            return $order;
        }
        return Response::HTTP_CREATED;
    }
}
