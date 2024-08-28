<?php

namespace App\Enums;

enum StatusType: string
{
    case Pending = 'pending';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Ended = 'ended';
}
