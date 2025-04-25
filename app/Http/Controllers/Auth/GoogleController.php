<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $existingUser = User::where('email', $googleUser->email)->first();

            if ($existingUser) {
                $isFirstTimeGoogleLogin = empty($existingUser->google_id);
                
                $existingUser->update([
                    'google_id' => $googleUser->id,
                    'email_verified_at' => now()
                ]);

                if ($isFirstTimeGoogleLogin) {
                    Mail::to($existingUser->email)->send(new WelcomeEmail($existingUser));
                }

                Auth::login($existingUser);
            } else {
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make($googleUser->id),
                    'email_verified_at' => now(),
                ]);

                Mail::to($newUser->email)->send(new WelcomeEmail($newUser));
                Auth::login($newUser);
            }

            return redirect()->route('user.dashboard');

        } catch (Exception $e) {
            Log::error('Google Auth Error: '.$e->getMessage());
            return redirect()->route('login')->with('error', 'Login with Google failed');
        }
    }
}
