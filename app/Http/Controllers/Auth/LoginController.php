<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{

    public function __construct(){
        $this->middleware('admin')->only('logOut');
    }

    public function loginPage(){

        // If Authenticated user logged In
        if (Auth::check()){
            return Redirect::route('admin.dashboard');
        }

        return view('backend.auth.login');

    }

    public function loginAction(Request $request){

        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('admin.dashboard'));
        }else{
            return redirect()->back()->with('error', 'Email Or password invalid!');
        }

    }

    public function logOut(){

        Auth::logout();

        return Redirect::route('admin.login');

    }

}
