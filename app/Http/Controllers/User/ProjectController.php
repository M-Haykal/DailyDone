<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function show($id) {
        $project = Project::findOrFail($id);
        return view('user.pages.list-page', compact('project'));
    }
    
    public function create(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        if ($project) {
            return redirect()->route('user.dashboard')->with('success', 'Project created successfully!');
        }

        return redirect()->back()->with('error', 'Something went wrong!');
    }
}
