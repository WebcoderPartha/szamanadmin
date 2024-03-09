<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.

    /**
     * Show the form for creating a new resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(5);
        return view('backend.user.index',compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('backend.user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        return $request->all();
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'gender' => 'required',
            'profession' => 'required',
            'status' => 'required',
            'nationality' => 'required',
            'remarks' => 'required',
//            'image' => 'required|file',
        ]);

        // Image Update
        if ($request->file('image')){

            $file = $request->file('image');
            $image = 'profile-'.Str::slug($request->name,'-').'.'.$file->getClientOriginalExtension();
            $directory = 'uploads/profile/'.$image;
            Image::make($file)->resize('600', '600')->save($directory);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'gender' => $request->gender,
                'profession' => $request->profession,
                'status' => $request->status,
                'nationality' => $request->nationality,
                'remarks' => $request->remarks,
                'image' => $directory
            ]);

        }else{

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'gender' => $request->gender,
                'profession' => $request->profession,
                'status' => $request->status,
                'nationality' => $request->nationality,
                'remarks' => $request->remarks,
            ]);

        }

        return redirect()->back()->with('success', 'User Created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = User::find($user);
        return view('backend.user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user = User::find($user);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('backend.user.edit',compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($user);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$user)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {

        // If user image null
        if (!$user->image == NULL){
            // If file exist
            if (file_exists(public_path($user->image))){
                // Remove image from folder
                unlink(public_path($user->image));
                $user->delete();

                return redirect()->route('users.index')->with('success','User updated successfully');

            }else{

                $user->delete();
                return redirect()->route('users.index')->with('success','User updated successfully');
            }

        }else{

            $user->delete();
            return redirect()->route('users.index')->with('success','User updated successfully');
        }

    }
}
