<?php

namespace Database\Seeders;

use App\Http\Domains\Project\Model\Project;
use App\Http\Domains\TimeSheet\Model\Timesheet;
use App\Http\Domains\User\Model\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TimesheetSeeder  extends Seeder
{
    public function run()
    {
        $users = User::all();
        $today = Carbon::now();

        foreach ($users as $user) {
            $userProjects = $user->projects;
            if ($userProjects->isEmpty()) {
                continue;
            }

            // Create timesheets for the last 30 days
            for ($i = 0; $i < 30; $i++) {
                $date = $today->copy()->subDays($i);
                $projectCount = rand(1, min(2, $userProjects->count()));
                $dayProjects = $userProjects->random($projectCount);

                foreach ($dayProjects as $project) {
                    Timesheet::create([
                        'task_name' => 'Work on ' . $project->name,
                        'date' => $date->format('Y-m-d'),
                        'hours' => rand(1, 8),
                        'user_id' => $user->id,
                        'project_id' => $project->id,
                    ]);
                }
            }
        }
    }
}
