<?php

namespace App\Enums;

enum PaymentType: int
{
    case CREDIT = 1;
    case DEBIT = 2;
    case PIX = 3;
    case CASH = 4;
}
