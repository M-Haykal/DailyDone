<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\SharedProject;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function show($id) {
        $userId = auth()->id();
    
        $project = Project::where('id', $id)
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                        ->orWhereHas('sharedUsers', function ($subQuery) use ($userId) {
                            $subQuery->where('user_id', $userId);
                        });
            })
            ->firstOrFail();
    
        return view('user.pages.list-page', compact('project'));
    }
    
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        
        $project = new Project();
        $project->user_id = auth()->id();
        $project->name = $request->name;
        $project->description = $request->description;
        $project->save();
        
        return redirect()->back()->with('success', 'Task created successfully');
    }
    

    public function share(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'permissions' => 'required|in:view,edit',
        ]);

        $project = Project::findOrFail($id);
        $receiver = User::where('email', $request->email)->first();

        if (!$receiver) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        $token = Str::random(32);

        $project->sharedUsers()->syncWithoutDetaching([
            $receiver->id => [
                'permissions' => $request->permissions,
                'token' => $token,
                'expires_at' => now()->addDays(7),
            ],
        ]);

        Mail::to($receiver->email)->send(new SendEmail([
            'subject' => "Anda telah diberikan akses ke proyek: {$project->name}",
            'token' => $token,
            'project' => $project
        ]));

        return response()->json(['message' => 'Proyek berhasil dibagikan.'], 200);
    }

    public function joinProject($token)
    {
        $sharedProject = SharedProject::where('token', $token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$sharedProject) {
            return redirect('/')->with('error', 'Token tidak valid atau sudah kedaluwarsa.');
        }

        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Silakan login untuk mengakses proyek.');
        }

        if ($sharedProject->user_id !== auth()->id()) {
            $sharedProject->update(['user_id' => auth()->id()]);
        }

        return redirect()->route('projects.show', ['id' => $sharedProject->project_id])
            ->with('success', 'Berhasil bergabung ke proyek.');
    }

    public function accessProject($token)
    {
        $sharedProject = DB::table('shared_projects')->where('token', $token)->first();
        if (!$sharedProject || now()->greaterThan($sharedProject->expires_at)) {
            return abort(403, 'Token tidak valid atau telah kedaluwarsa.');
        }
        $project = Project::findOrFail($sharedProject->project_id);
        return redirect()->route('projects.show', ['id' => $project->id])
            ->with('success', 'Anda berhasil mengakses proyek ini.');
    }

}
