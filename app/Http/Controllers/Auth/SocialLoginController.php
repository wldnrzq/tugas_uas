<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('google_id', $user->id)->first();

            if ($findUser) {
                Auth::login($findUser);
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'provider' => 'google',
                    'password' => bcrypt('defaultpassword'), // Password default (opsional)
                ]);
                Auth::login($newUser);
            }

            return redirect()->route('dashboard');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function redirectToGitHub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGitHubCallback()
    {
        try {
            $user = Socialite::driver('github')->user();
            $findUser = User::where('github_id', $user->id)->first();

            if ($findUser) {
                Auth::login($findUser);
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'github_id' => $user->id,
                    'provider' => 'github',
                    'password' => bcrypt('defaultpassword'), // Password default (opsional)
                ]);
                Auth::login($newUser);
            }

            return redirect()->route('dashboard');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}