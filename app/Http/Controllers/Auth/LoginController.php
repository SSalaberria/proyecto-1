<?php

namespace Listbook\Http\Controllers\Auth;

use Listbook\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Listbook\User;
use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGitHubProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderGitHubCallback()
    {
        $githubUser = Socialite::driver('github')->user();
        $user = User::firstOrCreate([
            'email' => $githubUser->getEmail()
        ], [
            'username' => $githubUser->getNickname(),
            'password' => str_random(25),
        ]);
        auth()->login($user);

        return redirect('/');
    }
}
