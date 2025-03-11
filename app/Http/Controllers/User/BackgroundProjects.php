<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\BackgroundProject;
use Illuminate\Http\Request;

class BackgroundProjects extends Controller
{
    public function index(Request $request) {
        return BackgroundProject::where('project_id', $request->project_id)
            ->where('user_id', auth()->id())
            ->get();
    }
    
    public function store(Request $request) {
        $project = Project::findOrFail($request->project_id);

        $request->validate([
            'image_project' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $BackgroundProjects = BackgroundProjects::create([
            'image_project' => $request->image_project,
            'project_id' => $request->project_id,
        ]);

        return redirect()->back()->with('success', 'Background Project created successfully!');
    }
}
