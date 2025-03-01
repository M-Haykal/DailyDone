<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Project;
use App\Models\User;

class UsersController extends Controller
{
    public function index() {
        $projects = Project::where('user_id', auth()->id())->simplePaginate(5);
        return view('user.dashboard', compact('projects'));
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
