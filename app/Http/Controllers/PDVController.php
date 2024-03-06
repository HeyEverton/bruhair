<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Services\CustomerService;
use App\Services\ProductService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class PDVController extends Controller
{

    public function __construct(
        private readonly CustomerService $service,
        private readonly ProductService  $productService,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $customers = $this->service->list();
        $products = $this->productService->list();
        return Inertia::render('Pdv', [
            'customers' => $customers,
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCustomerRequest $request)
    {
        try {
            $data = $request->validated();
            $this->service->create($data);
        } catch (\Exception $exception) {
            Log::error($exception);
            throw $exception;
        }
    }

}
