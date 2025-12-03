<?php

namespace App\Enums;

enum CountStatus: string
{
    case COUNTED = 'counted';
    case CHECKED = 'checked';
    case VERIFIED = 'verified';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
