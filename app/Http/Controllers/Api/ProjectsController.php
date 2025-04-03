<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectsController extends Controller
{
    public function getProjectByUserId()
    {
        $projects = Project::where('user_id', Auth::id())->get();

        return response()->json([
            'success' => true,
            'projects' => $projects
        ]);
    }

    public function getProjectById($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'project' => $project
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'slug' => Str::slug($request->name) . '-' . Str::random(6),
            'user_id' => Auth::user()->id,
        ]);

        return response()->json([
            'success' => true,
            'project' => $project
        ], 201);
    }

    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:255',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'background_project' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $project = Project::findOrFail($id);

        if ($project->user_id != Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $project->name = $request->input('name') ?? $project->name;
        $project->description = $request->input('description') ?? $project->description;
        $project->start_date = $request->input('start_date') ?? $project->start_date;
        $project->end_date = $request->input('end_date') ?? $project->end_date;

        if ($request->hasFile('background_project')) {
            $image = $request->file('background_project');
            $filename = md5($image->getClientOriginalName() . time()) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/bgProject', $filename);
            $project->background_project = $filename;
        }

        $project->update([
            'name' => $project->name,
            'description' => $project->description,
            'start_date' => $project->start_date,
            'end_date' => $project->end_date,
            'background_project' => $project->background_project,
        ]);

        return response()->json([
            'success' => true,
            'message' => $project->fresh()
        ], 200);
    }

}
