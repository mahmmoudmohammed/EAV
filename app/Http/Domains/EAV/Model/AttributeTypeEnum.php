<?php

namespace App\Http\Domains\EAV\Model;

enum AttributeTypeEnum: string
{
    case TEXT = 'text';
    case DATE = 'date';
    case NUMBER = 'number';
    case SELECT = 'select';
    public static function values(): array
    {
        return collect(self::cases())->pluck('value')->toArray();
    }
}
