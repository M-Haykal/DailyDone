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
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function show($id) {
        $userId = Auth::id();
        $userEmail = Auth::user()->email;
    
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
        $project->user_id = Auth::id();
        $project->name = $request->name;
        $project->description = $request->description;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->save();
        
        return redirect()->back()->with('success', 'Task created successfully');
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'background_project' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $project = Project::findOrFail($id);
        
        if ($project->user_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit proyek ini.');
        }
        
        if ($request->hasFile('background_project')) {
            $image = $request->file('background_project');
            $filename = md5($image->getClientOriginalName().time()).'.'.$image->getClientOriginalExtension();
            $image->storeAs('public/bgProject', $filename);
            $project->background_project = $filename;
        } else {
            $project->background_project = $request->background_project;
        }
        
        $project->save();
        
        return redirect()->back()->with('success', 'Proyek berhasil diedit.');
    }

    public function saveNote(Request $request, Project $project)
    {
        if ($project->user_id != Auth::id() && 
            !$project->sharedUsers()->where('user_id', Auth::id())->where('permissions', 'edit')->exists()) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menambahkan catatan.');
        }

        $request->validate([
            'note' => 'required|string|max:2000',
        ]);

        $project->update([
            'note' => $request->note,
            'completed_at' => now()
        ]);

        return back()->with('success', 'Catatan project berhasil disimpan.');
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
            'user_id' => $receiver ? $receiver->id : null,
            'email' => $request->email,
            'permissions' => $request->permissions,
            'token' => $token,
            'expires_at' => now()->addDays(7),
        ]);
    
        Mail::to($request->email)->send(new SendEmail([
            'subject' => "Anda telah diberikan akses ke proyek: {$project->name}",
            'token' => $token,
            'project' => $project
        ]));
    
        return redirect()->back()->with('success', 'Proyek berhasil dibagikan.');
    }

    public function editPermission(Request $request, Project $project, SharedProject $sharedProject)
    {
        if ($project->user_id != Auth::id()) {
            return back()->with('error', 'Hanya pemilik proyek yang dapat mengubah izin.');
        }
    
        if ($sharedProject->project_id != $project->id) {
            return back()->with('error', 'Izin tidak valid untuk proyek ini.');
        }
    
        $request->validate([
            'permissions' => 'required|in:view,edit',
        ]);
    
        $sharedProject->update([
            'permissions' => $request->permissions
        ]);
    
        return back()->with('success', 'Izin berhasil diperbarui.');
    }

    public function deleteAccess(Project $project, SharedProject $sharedProject)
    {
        if ($project->user_id != Auth::id()) {
            return back()->with('error', 'Hanya pemilik proyek yang dapat menghapus akses.');
        }

        if ($sharedProject->project_id != $project->id) {
            return back()->with('error', 'Akses tidak valid untuk proyek ini.');
        }

        $sharedProject->delete();

        return back()->with('success', 'Akses berhasil dihapus.');
    }

    public function joinProject($token)
    {
        $sharedProject = SharedProject::where('token', $token)
            ->where('expires_at', '>', now())
            ->first();
    
        if (!$sharedProject) {
            return redirect('/')->with('error', 'Token tidak valid atau sudah kedaluwarsa.');
        }
    
        if (!Auth::check()) {
            session(['redirect_to_project' => $sharedProject->project_id]);
    
            return redirect('login')->with('error', 'Silakan login atau register untuk mengakses proyek.');
        }

        if ($sharedProject->user_id == null) {
            $sharedProject->user_id = Auth::id();
            $sharedProject->save();
        }
    
        return redirect()->route('projects.show', ['id' => $sharedProject->project_id])
            ->with('success', 'Berhasil bergabung ke proyek.');
    }
    

    public function accessProject($token)
    {
        $sharedProject = SharedProject::where('token', $token)->first();

        if (!$sharedProject) {
            abort(404);
        }

        if (now()->greaterThan($sharedProject->expires_at)) {
            abort(403, 'Token telah kedaluwarsa.');
        }

        if (!Auth::check()) {
            session(['pending_project_token' => $token]);
            return redirect('/register')->with('info', 'Silakan daftar atau login terlebih dahulu.');
        }

        $project = Project::findOrFail($sharedProject->project_id);
        if ($project->trashed()) {
            abort(404);
        }

        return redirect()->route('projects.show', ['id' => $project->id])
            ->with('success', 'Anda berhasil mengakses proyek ini.');
    }

    public function trashedProjects()
    {
        $projects = Project::onlyTrashed()->where('user_id', Auth::id())->get();
        return view('user.pages.trash-project-page', compact('projects'));
    }

    public function deleteProject($id)
    {
        $project = Project::findOrFail($id);
        if ($project->user_id != Auth::id()) {
            return abort(403, 'Anda tidak memiliki izin untuk menghapus proyek ini.');
        }
        foreach ($project->taskLists as $taskList) {
            $taskList->delete();
        }
        $project->delete();
        return redirect()->route('user.dashboard')->with('success', 'Proyek berhasil dihapus.');
    }

    public function restoreProject($id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        if ($project->user_id != Auth::id()) {
            return abort(403, 'Anda tidak memiliki izin untuk mengembalikan proyek ini.');
        }

        $project->restore();

        return redirect()->route('user.dashboard')->with('success', 'Proyek berhasil dikembalikan.');
    }

    public function forceDeleteProject($id)
    {
        $project = Project::onlyTrashed()->findOrFail($id);

        if ($project->user_id != Auth::id()) {
            return abort(403, 'Anda tidak memiliki izin untuk menghapus proyek ini secara permanen.');
        }

        $project->forceDelete(); // Hapus permanen dari database

        return redirect()->route('user.dashboard')->with('success', 'Proyek berhasil dihapus secara permanen.');
    }

    public function shareBySlug(Request $request, $slug)
    {
        $request->validate([
            'permissions' => 'required|in:view,edit',
        ]);
    
        $project = Project::where('slug', $slug)->firstOrFail();
    
        if ($project->user_id !== Auth::id()) {
            return abort(403, 'Anda tidak memiliki izin untuk membagikan proyek ini.');
        }
    
        // Generate token berdasarkan permission
        $tokenType = $request->permissions . '_token';
        $expiresType = $request->permissions . '_expires_at';
        
        $token = Str::random(32);
        $expiresAt = now()->addDays(7);
    
        SharedProject::updateOrCreate(
            [
                'project_id' => $project->id,
                'permissions' => $request->permissions
            ],
            [
                'token' => $token,
                'expires_at' => $expiresAt,
                // Simpan juga di field khusus jika diperlukan
                $tokenType => $token,
                $expiresType => $expiresAt
            ]
        );
    
        $shareUrl = route('projects.access', [
            'slug' => $project->slug,
            'token' => $token,
            'permission' => $request->permissions // Tambahkan parameter permission
        ]);
    
        session()->flash('share_url', $shareUrl);
        session()->flash('permission_type', $request->permissions);
    
        return back();
    }

    public function accessBySlug($slug, $token)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        $sharedProject = SharedProject::where('token', $token)
                        ->where('project_id', $project->id)
                        ->first();
    
        if (!$sharedProject) {
            return abort(404, 'Token tidak valid.');
        }
    
        if (now()->greaterThan($sharedProject->expires_at)) {
            return abort(403, 'Token telah kedaluwarsa.');
        }
    
        if (!Auth::check()) {
            session(['pending_project_token' => $token]);
            return redirect('/login')->with('info', 'Silakan login terlebih dahulu.');
        }
    
        // Update user_id jika belum ada
        if ($sharedProject->user_id === null) {
            $sharedProject->user_id = Auth::id();
            $sharedProject->save();
        }
    
        return redirect()->route('projects.show', ['id' => $project->id])
            ->with('success', 'Anda berhasil mengakses proyek ini dengan izin ' . $sharedProject->permissions);
    }

    public function archive(Project $project)
    {
        $project->archive();
        return redirect()->route('user.dashboard')
            ->with('success', 'Project berhasil diarsipkan');
    }

    public function activate(Project $project)
    {
        $project->activate();
        return redirect()->route('user.dashboard')
            ->with('success', 'Project berhasil diaktifkan kembali');
    }

}

