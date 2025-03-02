<?php

namespace Database\Seeders;

use App\Http\Domains\EAV\Model\Attribute;
use App\Http\Domains\EAV\Model\AttributeValue;
use App\Http\Domains\Project\Model\Project;
use App\Http\Domains\Project\Model\ProjectStatusEnum;
use App\Http\Domains\User\Model\User;
use Illuminate\Database\Seeder;

class ProjectSeeder  extends Seeder
{
    public function run()
    {
        $users = User::all();

        $departmentAttr = Attribute::where('name', 'department')->first();
        $startDateAttr = Attribute::where('name', 'start_date')->first();
        $endDateAttr = Attribute::where('name', 'end_date')->first();

        $project1 = Project::create([
            'name' => 'Website Redesign',
            'status' => ProjectStatusEnum::IN_PROGRESS,
        ]);

        // Assign all users to project 1
        $project1->users()->attach($users->pluck('id'));

        AttributeValue::create([
            'attribute_id' => $departmentAttr->id,
            'entity_id' => $project1->id,
            'entity_type' => Project::class,
            'value' => 'IT',
        ]);

        AttributeValue::create([
            'attribute_id' => $startDateAttr->id,
            'entity_id' => $project1->id,
            'entity_type' => Project::class,
            'value' => '2023-01-01',
        ]);

        AttributeValue::create([
            'attribute_id' => $endDateAttr->id,
            'entity_id' => $project1->id,
            'entity_type' => Project::class,
            'value' => '2023-06-30',
        ]);


        $project2 = Project::create([
            'name' => 'Mobile App Development',
            'status' => ProjectStatusEnum::PENDING,
        ]);

        // Assign first two users to project 2
        $project2->users()->attach($users->take(2)->pluck('id'));

        AttributeValue::create([
            'attribute_id' => $departmentAttr->id,
            'entity_id' => $project2->id,
            'entity_type' => Project::class,
            'value' => 'IT',
        ]);

        AttributeValue::create([
            'attribute_id' => $startDateAttr->id,
            'entity_id' => $project2->id,
            'entity_type' => Project::class,
            'value' => '2023-07-01',
        ]);

        AttributeValue::create([
            'attribute_id' => $endDateAttr->id,
            'entity_id' => $project2->id,
            'entity_type' => Project::class,
            'value' => '2023-12-31',
        ]);
    }
}
