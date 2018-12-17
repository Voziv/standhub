<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;

class GoogleController extends Controller
{
    public function __construct()
    {
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirectUrl(config('services.google.redirect'))->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->redirectUrl(config('services.google.redirect'))->stateless()->user();

            if (stripos($googleUser->getEmail(), '@ratehub.ca') === false) {
                throw new AuthorizationException("You shalt not pass");
            }

            $existUser = User::query()->where('email', $googleUser->getEmail())->first();

            if ($existUser) {
                Auth::loginUsingId($existUser->id);
            } else {
                $user = new User;
                $user->name = $googleUser->getName();
                $user->email = $googleUser->getEmail();
                $user->google_id = $googleUser->getId();
                $user->password = md5(rand(1, 10000));
                $user->save();
                Auth::loginUsingId($user->id);
            }
            return redirect()->to('/home');
        } catch (\Exception $e) {
            throw $e;
            return 'error';
        }
    }
}
