<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\BackgroundProjects;

class backgroundProjectController extends Controller
{
    public function index(Request $request) {
        $backgroundProjects = BackgroundProjects::where('project_id', $request->project_id)
            ->where('user_id', auth()->id())
            ->select('image_project')
            ->get();

        return view('user.modal.edit-background-image', compact('backgroundProjects'));
    }
    
    public function store(Request $request) {
        $project = Project::findOrFail($request->project_id);
    
        $request->validate([
            'image_project' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'project_id' => 'nullable|exists:projects,id',
        ]);
    
        $filePath = $request->file('image_project')->store('public/bgProject');
    
        $BackgroundProjects = BackgroundProjects::create([
            'image_project' => str_replace('public/', 'storage/', $filePath), 
            'project_id' => $request->project_id,
            'user_id' => auth()->user()->id,
        ]);
    
        return redirect()->back()->with('success', 'Background Project created successfully!');
    }
}

