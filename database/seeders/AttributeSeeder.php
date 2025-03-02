<?php

namespace Database\Seeders;

use App\Http\Domains\EAV\Model\Attribute;
use App\Http\Domains\EAV\Model\AttributeTypeEnum;
use Illuminate\Database\Seeder;

class AttributeSeeder  extends Seeder
{
    public function run()
    {

        Attribute::create([
            'name' => 'start_date',
            'type' => AttributeTypeEnum::DATE,
        ]);

        Attribute::create([
            'name' => 'department',
            'type' => AttributeTypeEnum::SELECT,
            'options' => ['IT', 'Marketing', 'Sales', 'Finance', 'HR'],
        ]);

        Attribute::create([
            'name' => 'end_date',
            'type' => AttributeTypeEnum::DATE,
        ]);
    }
}
