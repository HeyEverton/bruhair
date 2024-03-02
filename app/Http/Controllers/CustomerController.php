<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Services\CustomerService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    public function __construct(private CustomerService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->query();
        $customers = $this->service->index($query);
        return Inertia::render('Customer/Index', [
            'customers' => $customers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Customer/Create');
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = $this->service->show($id);
        return Inertia::render('Customer/Edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $this->service->update($data, $id);
        } catch (\Exception $exception) {
            Log::error($exception);
            throw $exception;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {

        if (auth()->user()->id === $id) {
            return abort(403, 'Você não pode excluir seu próprio usuário');
            /*return Inertia::render('Error', ['message' => 'Você não pode excluir seu próprio usuário.'])->toResponse(request())->setStatusCode(403);*/
        }
        $this->service->destroy($id);
        return redirect('customers');
    }
}
