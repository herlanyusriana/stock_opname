<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case KEEPER = 'keeper';
    case AUDITOR = 'auditor';
    case SPV = 'spv';
}
