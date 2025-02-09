<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function show($id) {
        $project = Project::where('user_id', auth()->user()->id)->findOrFail($id);
        return view('user.pages.list-page', compact('project'));
    }
    
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);
    
        return redirect()->back()->with('success', 'Project created successfully!');
    }    
}
