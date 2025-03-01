<?php

namespace App\Http\Domains\EAV\Model;

enum AttributeTypeEnum: string
{
    case TEXT = 'text';
    case DATE = 'date';
    case NUMBER = 'number';
    case SELECT = 'select';
}
