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
        $userEmail = auth()->user()->email;
    
        $project = Project::where('id', $id)
            ->where(function ($query) use ($userId, $userEmail) {
                $query->where('user_id', $userId)
                    ->orWhereHas('sharedUsers', function ($subQuery) use ($userId, $userEmail) {
                        $subQuery->where('shared_projects.user_id', $userId)
                            ->orWhere('shared_projects.email', $userEmail); // Tambahkan alias 'shared_projects.email'
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
        $token = Str::random(32);
    
        SharedProject::create([
            'project_id' => $id,
            'user_id' => $receiver ? $receiver->id : null, // Bisa NULL jika user belum register
            'email' => $request->email, // Simpan email untuk user yang belum register
            'permissions' => $request->permissions,
            'token' => $token,
            'expires_at' => now()->addDays(7),
        ]);
    
        Mail::to($request->email)->send(new SendEmail([
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
            session(['redirect_to_project' => $sharedProject->project_id]);
    
            return redirect('login')->with('error', 'Silakan login atau register untuk mengakses proyek.');
        }

        if ($sharedProject->user_id == null) {
            $sharedProject->user_id = auth()->id();
            $sharedProject->save();
        }
    
        return redirect()->route('projects.show', ['id' => $sharedProject->project_id])
            ->with('success', 'Berhasil bergabung ke proyek.');
    }
    

    public function accessProject($token)
    {
        $sharedProject = SharedProject::where('token', $token)->first();

        if (!$sharedProject || now()->greaterThan($sharedProject->expires_at)) {
            return abort(403, 'Token tidak valid atau telah kedaluwarsa.');
        }

        if (!auth()->check()) {
            session(['pending_project_token' => $token]);
            return redirect('/register')->with('info', 'Silakan daftar atau login terlebih dahulu.');
        }

        return redirect()->route('projects.show', ['id' => $sharedProject->project_id])
            ->with('success', 'Anda berhasil mengakses proyek ini.');
    }


}
