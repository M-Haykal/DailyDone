<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\User\ProjectService;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function store(Request $request)
    {
        return $this->projectService->store($request);
    }

    public function update(Request $request, Project $project)
    {
        return $this->projectService->update($request, $project);
    }

    public function destroy(Project $project)
    {
        return $this->projectService->destroy($project);
    }
}