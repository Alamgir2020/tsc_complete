<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback(Request $request)
    {
        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            // dd($finduser);

            if ($finduser) {

                Auth::login($finduser);

                return redirect('/home');
            } else {

                $request->validate(
                    [
                        'email' => 'bail|required',

                    ]
                );
                $newUser = User::create(
                    [
                        'name' => $user->name,
                        'email' => $user->email,
                        'google_id' => $user->id,
                        // 'password' => encrypt('123456dummy'),
                        'password' => uniqid(),
                    ]
                );

                Auth::login($newUser);

                return redirect('/home');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
