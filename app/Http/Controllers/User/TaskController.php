<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskList;
use App\Models\Project;
use App\Models\User;

class TaskController extends Controller
{
    public function index(Request $request) {
        $project = Project::findOrFail($request->project_id);
        if (!view()->exists('user.pages.create-list-page')) {
            abort(404, 'View not found');
        }
        $users = User::all();
        return view('user.pages.create-list-page', ['project' => $project, 'users' => $users]);        
    }
    
    public function store(Request $request)
    {
        $project = Project::with('users')->findOrFail($request->project_id);
    
        $request->validate([
            'list_items' => 'required|string|max:255',
            'detail_list' => 'required|string|max:5000',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'tag' => 'required|array',
            'tag.*' => 'exists:users,id',
            'note' => 'required|string|max:255',
            'start_date' => [
                'required', 'date',
                'after_or_equal:' . $project->start_date,
                'before_or_equal:' . $project->end_date,
            ],
            'end_date' => [
                'required', 'date',
                'after_or_equal:start_date',
                'before_or_equal:' . $project->end_date,
            ],
            'project_id' => 'required|exists:projects,id',
        ]);
    
        $taskList = TaskList::create([
            'list_items' => $request->list_items,
            'detail_list' => htmlspecialchars($request->detail_list, ENT_QUOTES, 'UTF-8'),
            'status' => $request->status,
            'priority' => $request->priority,
            'tag' => implode(',', $request->tag),
            'note' => $request->note,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'project_id' => $request->project_id,
            'user_id' => Auth::id(),
        ]);
    
        // Simpan user yang dipilih
        $taskList->users()->attach($request->tag);
    
        return redirect()->back()->with('success', 'Task List created successfully!');
    }        

    public function show($id) {
        $project = Project::where('user_id', Auth::id())->findOrFail($id);
    
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

    public function destroy($id)
    {
        $task = TaskList::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task tidak ditemukan'], 404);
        }

        if (Auth::id() !== $task->project->user_id &&
            !$task->project->sharedUsers()->where('user_id', Auth::id())->where('permissions', 'edit')->exists()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $task->delete();

        return redirect()->back()->with('success', 'Task berhasil dihapus');
    }

    public function detailList($idProject, $idTaskList)
    {
        $userId = Auth::id();
        $userEmail = Auth::check() ? Auth::user()->email : null;

        $taskList = TaskList::where('project_id', $idProject)
            ->whereHas('project', function ($query) use ($userId, $userEmail) {
                $query->where('user_id', $userId)
                    ->orWhereHas('sharedUsers', function ($subQuery) use ($userId, $userEmail) {
                        $subQuery->where('shared_projects.user_id', $userId)
                            ->orWhere('shared_projects.email', $userEmail);
                    });
            })->findOrFail($idTaskList);

        $users = User::all();

        return view('user.pages.detail-list-page', compact('taskList', 'users'));
    }

    public function viewEdit($idProject, $idTaskList)
    {
        $tasklist = TaskList::where('project_id', $idProject)
            ->whereHas('project', function ($query) {
                $query->where('user_id', Auth::id());
            })->findOrFail($idTaskList);

        return view('user.pages.edit-list-page', compact('tasklist'));
    }

    public function edit(Request $request, $idProject, $idTaskList)
    {
        $task = TaskList::where('project_id', $idProject)
            ->whereHas('project', function ($query) {
                $query->where('user_id', Auth::id());
            })->findOrFail($idTaskList);

        if (!$task) {
            return back()->with('error', 'Task tidak ditemukan');
        }

        if (Auth::id() !== $task->project->user_id &&
            !$task->project->sharedUsers()->where('user_id', Auth::id())->where('permissions', 'edit')->exists()) {
            return back()->with('error', 'Unauthorized');
        }

        $validatedData = $request->validate([
            'list_items' => 'required|string',
            'detail_list' => 'nullable|string',
            'priority' => 'nullable|string',
            'tag' => 'nullable|string',
            'note' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date'
        ]);

        $task->update($validatedData);

        return back()->with('success', 'Task berhasil diupdate');
    }

}

