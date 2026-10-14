<?php

namespace App\Enums;

enum VerificationCodeType: string
{
    case EmailVerify = 'email_verify';
    case PasswordReset = 'password_reset';
}
