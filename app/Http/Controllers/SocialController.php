<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialController extends Controller
{
    //
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function loginWithFacebook(Request $request)
    {


        try {

            Socialite::driver('facebook')->stateless();

            $user = Socialite::driver('facebook')->user();
            //  dd($user);
            $isUser = User::where('fb_id', $user->id)->first();


            // dd($isUser);

            if ($isUser) {
                Auth::login($isUser);
                return redirect('/home');
            } else {

                $request->validate(
                    [
                        'email' => 'bail|required',

                    ]
                );

                $createUser = User::create(
                    [
                        'name' => $user->name,
                        'email' => $user->email,
                        'fb_id' => $user->id,
                        'password' => uniqid(),
                    ]
                );

                Auth::login($createUser);
                return redirect('/dashboard');
            }
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
