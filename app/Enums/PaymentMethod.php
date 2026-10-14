<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case NowPayments = 'nowpayments';
    case ManualCrypto = 'manual_crypto';
}
