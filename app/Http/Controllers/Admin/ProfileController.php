<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Intervention\Image\Facades\Image;

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

        $user = User::find(Auth::user()->id);

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'gender' => 'required',
            'profession' => 'required',
        ]);

        if ($request->file('image')){

            $file = $request->file('image');
            $image = 'profile-'.Str::slug($request->name,'-').'.'.$file->getClientOriginalExtension();
            $directory = 'uploads/profile/'.$image;
            Image::make($file)->resize('600', '600')->save($directory);

            // If Image request
            if ($user->image !== NULL){

                // If file exist
                if (file_exists(public_path($user->image))){

                    // Remove Image from Folder
                    unlink(public_path($user->image));

                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->gender = $request->gender;
                    $user->profession = $request->profession;
                    $user->image = $directory;
                    $user->save();

                }else{

                    $user->name = $request->name;
                    $user->email = $request->email;
                    $user->gender = $request->gender;
                    $user->profession = $request->profession;
                    $user->image = $directory;
                    $user->save();

                }

            }else{

                $user->name = $request->name;
                $user->email = $request->email;
                $user->gender = $request->gender;
                $user->profession = $request->profession;
                $user->image = $directory;
                $user->save();

            }

        }else{

            $user->name = $request->name;
            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->profession = $request->profession;
            $user->save();

        }

        return redirect()->route('admin.profile.edit')->with('success', 'User updated successfully');

    }


}
