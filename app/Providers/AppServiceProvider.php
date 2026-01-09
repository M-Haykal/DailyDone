<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Project;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Event;
use App\Models\SharedProject;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('user.layouts.app', function ($view) {
            $projects = Project::all();
            $now = \Carbon\Carbon::now();
            $threeDaysFromNow = $now->copy()->addDays(3);
            $projectsNotification = $projects->filter(function ($project) use ($now, $threeDaysFromNow) {
                $endDate = \Carbon\Carbon::parse($project->end_date);
                return ($project->user_id == Auth::id() || $project->sharedUsers->contains(Auth::id())) &&
                    $endDate->between($now, $threeDaysFromNow);
            });
            $view->with('projects', $projects)->with('projectsNotification', $projectsNotification);
        });

        Event::listen(Authenticated::class, function ($event) {
            $user = $event->user;
    
            // SharedProject::where('email', $user->email)
            //     ->whereNull('user_id')
            //     ->update(['user_id' => $user->id]);
        });
    }
}
