<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = '/home';

    /**
     * Google socialite instance
     *
     * @var Laravel\Socialite\Facades\Socialite
     */
    protected $socialiteGoogle = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $this->socialiteGoogle = Socialite::driver('google')->stateless();
    }

    /**
     * Redirect the user to the Google authentication page.
     * For additional parameters, check it here. 
     * https://developers.google.com/identity/protocols/OAuth2WebServer?hl=en#creatingclient
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        // add `prompt` parameter to redriect first to login/select google account page
        return $this->socialiteGoogle->with(['prompt' => 'select_account'])->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $googleUser = $this->socialiteGoogle->user();
        
        // check user by email
        $user = User::where([
            'email' => $googleUser->getEmail(),
            'can_login' => 1,
        ])->first();
        
        if (!empty($user)) {
            // set user token for user
            $token = $user->createToken('')->accessToken;

            return view('user.google', 
                [
                    'isSuccess' => true,
                    'accessToken' => $token,
                ]
            );
        } else {
            return view('user.google', 
                [
                    'isSuccess' => false,
                ]
            );
        }
    }
}
