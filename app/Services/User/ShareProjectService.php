<?php

namespace App\Services\User;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ShareProjectService
{
    public function shareToUser(
        Project $project,
        User $user,
        string $role,
        int $expireDays = 7
    ) {
        $token = Str::uuid()->toString();

        DB::table('project_user')->updateOrInsert([
            'project_id' => $project->slug,
            'user_id' => $user->id,
        ], [
            'role' => $role,
            'token' => $token,
            'expires_at' => Carbon::now()->addDays($expireDays),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user->syncRoles([$role === 'edit' ? 'editor' : 'viewer']);

        return $token;
    }

    public function shareByLink(
        Project $project,
        string $role,
        int $expireDays = 7
    ) {
        $token = Str::uuid()->toString();

        DB::table('project_user')->insert([
            'project_id' => $project->slug,
            'user_id' => null,
            'role' => $role,
            'token' => $token,
            'expires_at' => now()->addDays($expireDays),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return route('projects.access', [
            'slug' => $project->slug,
            'token' => $token,
        ]);
    }

    public function validateToken(Project $project, string $token)
    {
        return DB::table('project_user')
            ->where('project_id', $project->id)
            ->where('token', $token)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->first();
    }

    public function revokeAccess(Project $project, User $user)
    {
        DB::table('project_user')
            ->where('project_id', $project->id)
            ->where('user_id', $user->id)
            ->delete();

        $user->removeRole('editor');
        $user->removeRole('viewer');
    }
}
