<?php

namespace App\Enums;

enum UserRole: int
{
    case ADMIN = 1;
    case CUSTOMER = 2;
    case EMPLOYEE = 3;
}
