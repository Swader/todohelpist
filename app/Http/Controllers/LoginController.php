<?php

namespace Todohelpist\Http\Controllers;

use Todohelpist\Http\Requests;
use Todohelpist\Http\Controllers\Controller;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Socialize;

use Illuminate\Contracts\Auth\Guard;
use Todohelpist\Services\Todoist;
use Todohelpist\User;


class LoginController extends Controller
{
    protected $auth;
    protected $todoist;

    public function __construct(Guard $auth, Todoist $todoist)
    {
        $this->auth = $auth;
        $this->todoist = $todoist;
    }

    public function loginRegular(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $email = $request->get('email');

        try {
            $user = $this->todoist->getUser(['email' => $email, 'password' => $request->get('password')]);
        } catch (\Exception $e) {
            return redirect('/auth/login')->with([
                'flash_error' => "There's been an error: ".$e->getMessage()
            ]);
        }

        $this->auth->login($user);
        return redirect('/');
    }

    public function loginGoogle()
    {
        $user = Socialize::with('google')->user();

        try {
            $user = $this->todoist->getUser(
                [
                    'email' => $user->email,
                    'oauth2_token' => $user->token
                ], 'loginWithGoogle'
            );
        } catch (\Exception $e) {
            return redirect('/auth/login')->with([
                'flash_error' => "There's been an error: ".$e->getMessage()
            ]);
        }

        $this->auth->login($user);
        return redirect('/');
    }

    public function logout()
    {
        $this->auth->logout();

        return redirect('/');
    }

}
