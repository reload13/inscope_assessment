<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function redirectTo()
    {
        $user = auth()->user();

        // If the user is an admin, redirect to the companies listing page
        if ($user->hasRole(UserRole::Admin)) {
            return route('companies.index');
        }

        // If the user is a moderator, redirect them to the page where they choose a company
        if ($user->hasRole(UserRole::Moderator)) {
            return route('select-company');
        }

        // Default redirect for other users (or handle other roles if necessary)
        return '/home';
    }
}
