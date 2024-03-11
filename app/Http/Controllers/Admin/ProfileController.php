<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ProfileController extends Controller
{

    public function Profile(){
        if (Auth::user()){
            $roles = Role::pluck('name','name')->all();
            return view('backend.profile.edit', compact('roles'));
        }
    }

}
