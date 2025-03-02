<?php

namespace App\Http\Domains\Project\Model;

enum ProjectStatusEnum: int
{
    case PENDING = 0;
    case ACTIVE = 1;
    case INACTIVE = 2;
    case IN_PROGRESS = 3;
    case COMPLETED = 4;
    public static function values(): array
    {
        return collect(ProjectStatusEnum::cases())->pluck('value')->toArray();
    }
}
