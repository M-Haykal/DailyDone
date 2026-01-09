<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\User\ShareProjectService;
use App\Models\Project;
use App\Models\User;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

class ShareProjectController extends Controller
{
    protected $shareProjectService;

    public function __construct(ShareProjectService $shareProjectService)
    {
        $this->shareProjectService = $shareProjectService;
    }

    public function share(Request $request, Project $project)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|string',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $token = $this->shareProjectService->shareToUser(
            $project,
            $user,
            $request->role
        );

        Mail::to($user->email)->send(
            new SendEmail([
                'subject' => 'Akses Proyek Dibagikan',
                'project' => $project,
                'token' => $token,
            ])
        );

        return response()->json([
            'message' => 'Project berhasil dibagikan via email',
        ]);
    }

    public function shareLink(Request $request, Project $project)
    {
        $request->validate([
            'role' => 'required|in:view,edit',
        ]);

        $link = $this->shareProjectService->shareByLink(
            $project,
            $request->role
        );

        return response()->json([
            'link' => $link,
        ]);
    }

    public function access(string $slug, string $token)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        $share = $this->shareProjectService->validateToken($project, $token);

        abort_if(!$share, 403, 'Link tidak valid atau kadaluarsa');

        session([
            'shared_project_role' => $share->role,
            'shared_project_slug' => $project->slug,
        ]);

        return redirect()->route('projects.show', $project);
    }

    public function revokeAccess(Request $request, Project $project)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $user = User::findOrFail($request->input('user_id'));

        $this->shareProjectService->revokeAccess($project, $user);

        return response()->json([
            'message' => 'Akses proyek berhasil dicabut.',
        ]);
    }
}

