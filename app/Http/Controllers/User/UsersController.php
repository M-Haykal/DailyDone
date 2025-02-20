<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class UsersController extends Controller
{
    public function index() {
        $projects = Project::all();
        return view('user.dashboard', compact('projects'));
    }

    public function profile() {
        $user = User::where('id', auth()->id())->first();
        return view('user.pages.profile-page', compact('user'));
    }

    public function editProfile() {
        
    }
}
