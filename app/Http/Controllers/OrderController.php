<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Log;

class OrderController extends Controller
{

    public function __construct(private readonly OrderService $service)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = $this->service->index([]);
        return Inertia::render('Order/Index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrderRequest $request)
    {
        try {
            $data = $request->validated();
            $this->service->create($data);
        } catch (\Exception $exception) {
            Log::error($exception);
            throw $exception;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function searchOrders(Request $request)
    {

        if (!$request->query('date')) {
            $orders = $this->service->index([]);
            return Inertia::render('Order/Index', [
                'orders' => $orders,
            ]);
        }
        $orders = $this->service->filter($request->query('date'));

        return Inertia::render('Order/Index', [
            'orders' => $orders,
        ]);
    }
}
