<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{

    public function profileDetails(){
        if (Auth::user()){
            return view('backend.profile.detail', [
                'user' => Auth::user()
            ]);
        }
    }

    public function profileEdit(){
        if (Auth::user()){
            $roles = Role::pluck('name','name')->all();
            return view('backend.profile.edit', compact('roles'));
        }
    }

    public function updateProfile(Request $request){
        $userId = Auth::user()->id;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$userId,
            'gender' => 'required',
            'profession' => 'required',
        ]);
        return $request->all();
    }


}
