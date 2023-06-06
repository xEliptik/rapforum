<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected function authenticated()
    {
        if (Auth::user()->role_as == '1') //1 = Admin Login
        {
            return redirect('dashboard')->with('status', 'Bienvenido a tu panel');

        } elseif (Auth::user()->role_as == '0') // Normal or Default User Login
        {
            return back()->with('status', 'Sesión iniciada correctamente');

        }
    }

    public function username()
    {
        $loginValue = request()->input('email');

        $field = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$field => $loginValue]);

        return $field;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->route('login')->withErrors([
            $this->username() => trans('auth.failed'),
        ])->with('status', 'No fue posible iniciar sesión. Por favor, revise los datos de usuario proporcionados.');
    }

}