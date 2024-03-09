<?php

namespace App\Services;

use App\Base\BaseService;
use App\Enums\UserRole;
use App\Models\User;

class UserService extends BaseService
{
    public function __construct(private User $user)
    {
        parent::__construct($user);
    }

    public function listEmployees()
    {
        return $this->user
            ->where('role', UserRole::EMPLOYEE->value)
            ->get();
    }
}
