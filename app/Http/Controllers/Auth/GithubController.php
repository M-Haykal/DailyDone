<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Mockery\CountValidator\Exception;


class GithubController extends Controller
{
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback()
    {
        try {
            $user = Socialite::driver('github')->user();
        } catch (Exception $e) {
            return Redirect::to('auth/github');
        }

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        return redirect()->route('home');
    }

    private function findOrCreateUser($githubUser)
    {
        if ($authUser = User::where('github_id', $githubUser->getId())->first()) {
            return $authUser;
        }

        return User::create([
            'username' => $githubUser->eame(),
            'email' => $githubUser->email(),
            'github_id' => $githubUser->id(),
            'password' => Hash::make(uniqid()),
        ]);
    }
}