<?php

namespace App\Services\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectService
{
    public function store(Request $request)
    {
        $data = $this->validateRequest($request);

        $project = new Project();

        return $this->saveProject($project, $data);
    }

    public function update(Request $request, Project $project)
    {
        $data = $this->validateRequest($request, $project->slug);

        return $this->saveProject($project, $data);
    }

    public function destroy(Project $project)
    {
        $project->delete();
    }

    public function validateRequest(Request $request, $slug = null)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'user_id' => 'required|exists:users,id',
        ]);
    }

    public function saveProject(Project $project, array $data)
    {
        $auth = Auth::id();

        $project->fill([
            'name' => $data['name'],
            'description' => $data['description'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'user_id' => $auth,
        ])->save();

        return $project;
    }
}
