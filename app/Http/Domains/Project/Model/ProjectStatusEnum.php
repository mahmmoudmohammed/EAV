<?php

namespace App\Http\Domains\Project\Model;

enum ProjectStatusEnum: int
{
    case PENDING = 0;
    case ACTIVE = 1;
    case INACTIVE = 2;
    case iN_PROGRESS = 3;
    case COMPLETED = 4;
}
