<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function redirectTo()
    {
        switch (auth()->user()->role_id) {
            case 1:
                return RouteServiceProvider::ADMIN;
                break;
            case 2:
                return RouteServiceProvider::USER;
                break;
            case 3:
                return RouteServiceProvider::RESTAURANT;
                break;
            default:
                return RouteServiceProvider::HOME;
                break;

        }

    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function credentials(Request $request)
    {
        $login = $request->input($this->username());

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        return [
            $fieldType => $login,
            'password' => $request->input('password')
        ];
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
