<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

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
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $remember = $request->has('remember');

        if ($this->guard()->attempt($this->credentials($request), $remember)) {
            $request->session()->regenerate();

            return Redirect::intended($this->redirectPath());
        }

        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => [Lang::get('auth.failed')],
        ]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

    return Redirect::to('/');
    }

    protected function validateLogin(Request $request): void
    {
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function redirectPath(): string
    {
        return $this->redirectTo ?? RouteServiceProvider::HOME;
    }

    public function showLoginForm()
    {
        $title = 'Login';
        return View::make('frontend.auth.login')->with('title', $title);
    }

    protected function credentials(Request $request)
    {
        if(is_numeric($request->get('email'))){
            return ['nohp'=>$request->get('email'),'password'=>$request->get('password'),'status'=>'1'];
        }elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('email'), 'password'=>$request->get('password'),'status'=>'1'];
        }
        return ['name' => $request->get('email'), 'password'=>$request->get('password'),'status'=>'1'];
    }
}
