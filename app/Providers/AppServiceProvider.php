<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Project;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Event;
use App\Models\SharedProject;

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
            $view->with('projects', Project::all());
        });

        Event::listen(Authenticated::class, function ($event) {
            $user = $event->user;
    
            SharedProject::where('email', $user->email)
                ->whereNull('user_id')
                ->update(['user_id' => $user->id]);
        });
    }
}
