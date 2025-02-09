<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskList;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\Project;

class TaskController extends Controller
{
    public function index(Request $request) {
        $project = Project::findOrFail($request->project_id);
        if (!view()->exists('user.pages.create-list-page')) {
            abort(404, 'View not found');
        }
        return view('user.pages.create-list-page', ['project' => $project]);        
    }
    
    public function store(Request $request) {
        $request->validate([
            'list_items' => 'required|string|max:255',
            'detail_list' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'tag' => 'required|string|max:255',
            'note' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);
    
        $taskList = TaskList::create([
            'list_items' => $request->list_items,
            'detail_list' => $request->detail_list,
            'status' => $request->status,
            'priority' => $request->priority,
            'tag' => $request->tag,
            'note' => $request->note,
            'project_id' => $request->project_id,
            'user_id' => auth()->id(),
        ]);
    
        return redirect()->back()->with('success', 'Task List created successfully!');
    }

    public function show($id) {
        $project = Project::where('user_id', auth()->id())->findOrFail($id);
    
        $taskLists = $project->taskLists;
    
        return view('user.pages.list-page', compact('project', 'taskLists'));
    }

    public function updateStatus(Request $request, $id)
    {
        $task = TaskList::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task tidak ditemukan'], 404);
        }
    
        $task->status = $request->status;
        $task->save();
    
        return response()->json([
            'message' => 'Status berhasil diperbarui',
            'task_id' => $task->id,
            'new_status' => $task->status
        ]);
    }
    
}

