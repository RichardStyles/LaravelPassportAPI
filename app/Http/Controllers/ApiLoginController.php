<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

class ApiLoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $request->request->add([
            'username' => $email,
            'password' => $password,
            'grant_type' => 'password',
            'client_id' => env('API_CLIENT_ID'),
            'client_secret' => env('API_CLIENT_SECRET'),
            'scope' => '*'
        ]);

        $tokenRequest = Request::create(
            env('APP_URL').'/oauth/token',
            'post'
        );
        return Route::dispatch($tokenRequest)->getContent();
    }

}
