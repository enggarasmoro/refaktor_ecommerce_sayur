<?php

namespace App\Http\Controllers\Adminpanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function loginForm()
    {
        if (auth()->guard('admin')->check()){
            return redirect(route('bo.home'));
        } 
        return view('backoffice.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|exists:admin,username',
            'password' => 'required|string'
        ]);

        $auth = $request->only('username', 'password');
        $auth['status'] = 1;
        if (auth()->guard('admin')->attempt($auth)) {
            return redirect()->intended(route('bo.home'));
        }
        return redirect()->back()->with(['error' => 'Username / Password Salah']);
    }

    public function logout()
    {
        auth()->guard('admin')->logout();
        return redirect(route('bo.login'));
    }
}
