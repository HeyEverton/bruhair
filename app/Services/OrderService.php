<?php

namespace App\Services;

use Carbon\Carbon;
use App\Base\BaseService;
use App\Models\Order;
use Illuminate\Http\Response;

class OrderService extends BaseService
{
    public function __construct(
        private Order $order
    ) {
        parent::__construct($order);
    }

    public function index(array $options = [])
    {
        return $this->order
            ->with([
                'employee',
                'customer',
                'product',
            ])
            ->paginate($options);
    }

    public function create(array $payload, string $shouldReturnResource = 'no_return'): int | object
    {
        $payload['user_id'] = $payload['employee_id'];
        $payload['total'] = str_replace(',', '.', $payload['total']);
        $payload['total'] = str_replace('R$', '', $payload['total']);
        $payload['total'] = str_replace(' ', '', $payload['total']);
        $order = $this->order->create($payload);
        if ($shouldReturnResource === 'return_resource') {
            return $order;
        }
        return Response::HTTP_CREATED;
    }

    public function filter(string $date)
    {
        $query = $this->buildQuery($date);

        return [
            'data' => $query->with([
                'employee',
                'customer',
                'product',
            ])
                ->orderBy('created_at', 'DESC')
                ->get()
        ];
    }

    private function buildQuery(string $date)
    {
        $query = Order::query();
        switch ($date) {
            case 'day':
                $this->filterByDay($query);
                break;
            case 'week':
                $this->filterByWeek($query);
                break;
            case 'month':
                $this->filterByMonth($query);
                break;
            case 'all':
                $this->allOrders($query);
                break;
        }

        return $query;
    }

    private function filterByDay($query)
    {
        $today = Carbon::now()->format('Y-m-d');

        $query->whereDate('created_at', $today);
    }

    private function filterByWeek($query)
    {
        $initial = now()->subDays(7)->format('Y-m-d');
        $final = now()->format('Y-m-d');
        $query->whereBetween('created_at', [
            $initial . ' 00:00:00',
            $final . ' 23:59:59'
        ]);
    }

    private function filterByMonth($query)
    {
        $query->whereMonth('created_at', Carbon::now()->month);
    }

    private function allOrders($query)
    {
        $query->orderBy('created_at', 'DESC')->get();
    }
}
