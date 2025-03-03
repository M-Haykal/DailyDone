<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\TaskList;
use App\Models\Project;
use App\Models\User;

class UsersController extends Controller
{
    public function index() {
        $projects = Project::where('user_id', auth()->id())
            ->with('taskLists')
            ->simplePaginate(5);

        $taskList = TaskList::where('user_id', auth()->id())
            ->orderBy('start_date')
            ->orderBy('end_date')
            ->get();
        
        $tasks = $taskList->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => $task->list_items,
                'start' => $task->start_date,
                'end' => $task->end_date,
                'body' => $task->detail_list,
            ];
        })->toArray();

        $quote = Cache::remember('daily_quote', now()->endOfDay(), function () {
            $response = Http::get('https://dummyjson.com/quotes');
            $quotes = $response->json()['quotes'];
            return $quotes[array_rand($quotes)];
        });

        return view('user.dashboard', compact('projects', 'tasks', 'quote'));
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
