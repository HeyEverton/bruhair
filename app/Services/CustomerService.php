<?php

namespace App\Services;

use App\Base\BaseService;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Response;

class CustomerService extends BaseService
{
    public function __construct(private User $user)
    {
        parent::__construct($user);
    }

    public function index(array $options = [])
    {
        return [
            'data' => $this->user
                ->where('role', UserRole::CUSTOMER->value)
                ->orderBy($options['sort_by'] ?? 'name', $options['sort_order'] ?? 'ASC')
                ->limit(500)
                ->get()
        ];
    }

    public function create(array $payload, string $shouldReturnResource = 'no_return'): int|object
    {
        $payload['password'] = '12345678';
        $payload['role'] = UserRole::CUSTOMER->value;

        $customer = $this->user->create($payload);
        if ($shouldReturnResource === 'return_resource') {
            return $customer;
        }
        return Response::HTTP_CREATED;
    }

    public function list()
    {
        return $this->user
            ->where('role', '=', UserRole::CUSTOMER->value)
            ->get();
    }
}
