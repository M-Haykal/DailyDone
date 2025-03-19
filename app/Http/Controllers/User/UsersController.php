<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskList;
use App\Models\Project;
use App\Models\User;

class UsersController extends Controller
{
    public function index(Request $request) {
        // Initialize the query for Projects
        $projectsQuery = Project::where('user_id', auth()->id())
            ->with('taskLists');
    
        // Paginate the results
        $projects = $projectsQuery->simplePaginate(5);
    
        // Fetch the task list
        $taskList = TaskList::where('user_id', auth()->id())
            ->orderBy('start_date')
            ->orderBy('end_date')
            ->with('project')
            ->get();
        
        // Format the task list for the frontend
        $tasks = $taskList->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => $task->list_items,
                'start' => $task->start_date,
                'end' => $task->end_date,
                'project' => $task->project->name,
                'status' => $task->status
            ];
        })->toArray();
    
        // Group the tasks by status
        $taskStatus = collect($tasks)->groupBy('status');
    
        $user = User::findOrFail(Auth::id());
        $projectCount = Project::where('user_id', $user->id)->count();
        $taskListCount = TaskList::where('user_id', $user->id)->count();
        $userId = Auth::id();
        $projectEnded = Project::where('user_id', $user->id)
            ->where('end_date', '<', now())
            ->count();

        return view('user.dashboard', compact('projects', 'tasks', 'taskStatus', 'projectCount', 'taskListCount', 'projectEnded'));
    }

    public function archive() {
        $projects = Project::where('user_id', auth()->id())
        ->orWhereHas('sharedUsers', function ($query) {
            $query->where('user_id', auth()->id());
        })
        ->get();

        return view('user.pages.archive-page', compact('projects'));
    }
    
    public function deadline() {
        $projects = Project::where('user_id', auth()->id())
            ->orWhereHas('sharedUsers', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('start_date')
            ->orderBy('end_date')
            ->get();

        $project = $projects->map(function ($project) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'start_date' => $project->start_date,
                'end_date' => $project->end_date
            ];
        })->toArray();

        $taskList = TaskList::where('user_id', auth()->id())
            ->orderBy('start_date')
            ->orderBy('end_date')
            ->with('project')
            ->get();
        
        $tasks = $taskList->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => $task->list_items,
                'start' => $task->start_date,
                'end' => $task->end_date,
                'project' => $task->project->name
            ];
        })->toArray();

        return view('user.pages.deadline-page', compact('tasks', 'project'));
    }

    public function project(Request $request) {
        $projectsQuery = Project::where(function ($query) use ($request) {
            $query->where('user_id', auth()->id())
                ->orWhereHas('sharedUsers', function ($query) {
                    $query->where('user_id', auth()->id());
                });
        });
    
        if ($request->has('search') && !empty($request->search)) {
            $projectsQuery->where('name', 'like', '%' . $request->search . '%');
        }
    
        if ($request->has('sort')) {
            if ($request->sort === 'alphabetical') {
                $projectsQuery->orderBy('name');
            } elseif ($request->sort === 'deadline') {
                $projectsQuery->orderBy('end_date');
            }
        }
    
        $projects = $projectsQuery->simplePaginate(12);
    
        return view('user.pages.list-project-page', compact('projects'));
    }    

    public function profile() {
        $user = User::where('id', auth()->id())->first();
        return view('user.pages.profile-page', compact('user'));
    }

    public function editProfile() {
        $user = User::where('id', auth()->id())->first();
        return view('user.pages.edit-profile-page', compact('user'));
    }

    public function updateProfile(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
            'image_profile' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::where('id', auth()->id())->first();
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->hasFile('image_profile')) {
            $image = $request->file('image_profile');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/storage/images');
            $image->move($destinationPath, $name);
            $user->image_profile = $name;
        }
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
