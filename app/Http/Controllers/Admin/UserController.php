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
use Yajra\DataTables\Facades\Datatables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.

    /**
     * Show the form for creating a new resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*');
            return Datatables::of($data)
                ->addColumn('status', function($row){
                    if ($row->status == '1') {
                        $status = '<span class="badge badge-success px-2">Active</span>';
                        return $status;
                    }else{
                        $status = '<span class="badge badge-danger px-2">Inactive</span>';
                        return $status;
                    }
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm editUser" data-id="'.$row->id.'">Edit</a> <a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn deleteUser btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->addColumn('image', function($row){
                    if ($row->image !== null){
                        $image =  '<img src="'.asset($row->image).'" width="60" alt="">';
                        return $image;
                    }else{
                        $image =  '<img src="'.asset('uploads/profile/profile.jpg').'" width="60" alt="">';
                        return $image;
                    }
                })
                ->rawColumns(['status','action','image'])
                ->make(true);
        }
//        $users = User::latest()->paginate(10);
        return view('backend.user.index');

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
            'password' => 'required|confirmed|min:6',
            'gender' => 'required',
            'profession' => 'required',
            'status' => 'required',
            'nationality' => 'required',
            'remarks' => 'required',
//            'image' => 'required|file',
            'roles' => 'required'
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
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'profession' => $request->profession,
                'status' => $request->status,
                'nationality' => $request->nationality,
                'remarks' => $request->remarks,
                'image' => $directory
            ]);

            // Assigned Role from Spatie
            $user->assignRole($request->input('roles'));

        }else{

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'profession' => $request->profession,
                'status' => $request->status,
                'nationality' => $request->nationality,
                'remarks' => $request->remarks,
            ]);

            // Assigned Role from Spatie
            $user->assignRole($request->input('roles'));
        }

        return redirect()->route('users.index')->with('success', 'User Created successfully');

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

        $roles = Role::get();
        return view('backend.user.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {


        $user = User::find($id);


        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
//            'password' => 'required|confirmed|min:6',
            'gender' => 'required',
            'profession' => 'required',
            'status' => 'required',
            'remarks' => 'required',
            'roles' => 'required'
        ]);

        // Image Update
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

                    $update = User::findOrFail($id);
                    $update->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'gender' => $request->gender,
                        'profession' => $request->profession,
                        'status' => $request->status,
                        'nationality' => $request->nationality,
                        'remarks' => $request->remarks,
                        'image' => $directory
                    ]);

                    // Delete previous user role
                    DB::table('model_has_roles')->where('model_id',$user->id)->delete();
                    // Assigned Role from Spatie
                    $update->assignRole($request->input('roles'));


                }else{

                    $update= User::findOrFail($id);
                    $update->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'gender' => $request->gender,
                        'profession' => $request->profession,
                        'status' => $request->status,
                        'nationality' => $request->nationality,
                        'remarks' => $request->remarks,
                        'image' => $directory
                    ]);
                    // Delete previous user role
                    DB::table('model_has_roles')->where('model_id',$user->id)->delete();

                    $update->assignRole($request->input('roles'));
                }


            }else{


                $update = User::find($id);

                $update->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'gender' => $request->gender,
                    'profession' => $request->profession,
                    'status' => $request->status,
                    'nationality' => $request->nationality,
                    'remarks' => $request->remarks,
                    'image' => $directory
                ]);
                // Delete previous user role
                DB::table('model_has_roles')->where('model_id',$user->id)->delete();
                $update->assignRole($request->input('roles'));

            }



        }else{


            $update = User::find($id);
            $update->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'profession' => $request->profession,
                'status' => $request->status,
                'nationality' => $request->nationality,
                'remarks' => $request->remarks,
            ]);

            // Delete previous user role
            DB::table('model_has_roles')->where('model_id',$user->id)->delete();
            $update->assignRole($request->input('roles'));


//            // Assigned Role from Spatie
//            $update->assignRole($request->input('roles'));
        }


        return redirect()->route('users.index')->with('success', 'User updated successfully');
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

                return redirect()->route('users.index')->with('success','User deleted successfully');

            }else{

                $user->delete();
                return redirect()->route('users.index')->with('success','User deleted successfully');
            }

        }else{

            $user->delete();
            return redirect()->route('users.index')->with('success','User deleted successfully');
        }

    }
}
