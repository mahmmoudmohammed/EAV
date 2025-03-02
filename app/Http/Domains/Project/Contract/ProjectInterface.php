<?php

namespace App\Http\Domains\Project\Contract;

use App\Http\Domains\Project\Model\Project;
use App\Http\Repository\BaseCrudInterface;

interface ProjectInterface extends BaseCrudInterface
{
    public function load(Project $project, array|string $relations): Project;
}
