<?php

namespace App\Http\Domains\Project;


use App\Http\Controllers\Controller;
use App\Http\Domains\Project\Contract\ProjectInterface;
use App\Http\Domains\Project\Filter\ProjectFilter;
use App\Http\Domains\Project\Model\Project;
use App\Http\Domains\Project\Request\CreateProjectRequest;
use App\Http\Domains\Project\Request\UpdateProjectRequest;
use App\Http\Domains\Project\Resource\ProjectResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ProjectController extends Controller
{
    public function __construct(private ProjectInterface $repository)
    {
    }
    public function store(CreateProjectRequest $request)
    {
        $project = $this->repository->create($request->validated());
        $project = $this->repository->load($project, ['users','attributeValues.attribute']);

        return $this->responseResource(ProjectResource::make($project), status: 201);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project = $this->repository->update($project, $request->validated());
        $project = $this->repository->load($project, ['users','attributeValues.attribute']);

        return $this->responseResource(ProjectResource::make($project));
    }

    public function show(Project $project): ProjectResource|JsonResponse
    {
        return $this->responseResource(ProjectResource::make($project->load(['users','attributeValues.attribute'])));
    }

    public function delete(Project $project): JsonResponse
    {
        $deleted = $this->repository->delete($project);
        if (!$deleted)
            return $this->error(__('common.not_found'), 404);

        return $this->success();
    }

    public function index(Request $request): JsonResponse
    {
        $query = ProjectFilter::apply($request);
        $projects = $this->repository->list($query);

        return $this->responseResource(
            ProjectResource::collection($projects)
        );
    }

}
