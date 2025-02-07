<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class UsersController extends Controller
{
    public function index() {
        $projects = Project::all();
        return view('user.dashboard', compact('projects'));
    }
}
