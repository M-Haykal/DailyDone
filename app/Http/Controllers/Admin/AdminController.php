<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Notes;

class AdminController extends Controller
{
    public function dashboard() {
        $projectCount = Project::all()->count();
        $userCount = User::all()->count();
        $noteCount = Notes::all()->count();

        $projects = Project::all();

        return view('admin.dashboard', compact('projectCount', 'userCount', 'noteCount', 'projects'));
    }

    public function users() {
        $users = User::all();
        return view('admin.pages.user_page', compact('users'));
    }
}
