<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\User;
use App\Models\Product;
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
            $data = User::with('media')->get();
            return Datatables::of($data)
                ->addColumn('status', function($row){
                    if ($row->status == '1') {
                        $status = '<span class="badge badge-success px-2">Active</span>';
                        return $status;
                    }else{
                        $status = '<span class="badge badge-danger px-2">Inactive</span>';
                        return $status;
                    }
                })->addColumn('documents', function($row){
                    if (count($row->media) > 0){
                        foreach ($row->media as $document) {
                            return '<a download href="'.asset($document->file).'"><img width="35" src="'.asset('backend/images/file.jpg').'" alt=""></a>';
                        }
                    }

                })->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm editUser" data-id="'.$row->id.'">Edit</a> <a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn deleteUser btn-danger btn-sm">Delete</a> <a href="javascript:void(0)" class="edit btn btn-primary btn-sm userView" data-id="'.$row->id.'">View</a>';
                    return $actionBtn;
                })->addColumn('role', function ($row){
                    if(!empty($row->getRoleNames())){
                        foreach ($row->getRoleNames() as $role){
                            return '<label class="badge badge-info">'.$role.'</label>';
                        }
                    }
                })->addColumn('image', function($row){
                    if ($row->image !== null){
                        $image =  '<img src="'.asset($row->image).'" width="60" alt="">';
                        return $image;
                    }else{
                        $image =  '<img src="'.asset('uploads/profile/profile.jpg').'" width="60" alt="">';
                        return $image;
                    }
                })->rawColumns(['status','documents', 'action','image', 'role'])->make(true);
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

            // If request document
            if($request->input('document')){
                foreach ($request->input('document', []) as $file) {
                    Media::create([
                       'user_id' => $user->id,
                       'file' => 'uploads/documents/'.$file
                    ]);
                }
            }

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

            // If request document
            if($request->input('document')){
                foreach ($request->input('document', []) as $file) {
                    Media::create([
                        'user_id' => $user->id,
                        'file' => 'uploads/documents/'.$file
                    ]);
                }
            }

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
        $user = User::with('media')->find($user);
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
//            'remarks' => 'required',
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

                    // ========== If request document ======================
                    if($request->input('document')){

                        $fileHasExist = Media::where('user_id', $user->id)->get();

                        if ($fileHasExist){
                            foreach ($fileHasExist as $item){
                                if (file_exists(public_path($item->file))){
                                    unlink($item->file);
                                    Media::where('user_id', $user->id)->delete();
                                }
                            }
                        }

                        foreach ($request->input('document', []) as $file) {
                            Media::create([
                                'user_id' => $user->id,
                                'file' => 'uploads/documents/'.$file
                            ]);
                        }
                    }
                    // ========== If request document ======================

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

                    // ========== If request document ======================
                    if($request->input('document')){

                        $fileHasExist = Media::where('user_id', $user->id)->get();

                        if ($fileHasExist){
                            foreach ($fileHasExist as $item){
                                if (file_exists(public_path($item->file))){
                                    unlink($item->file);
                                    Media::where('user_id', $user->id)->delete();
                                }
                            }
                        }

                        foreach ($request->input('document', []) as $file) {
                            Media::create([
                                'user_id' => $user->id,
                                'file' => 'uploads/documents/'.$file
                            ]);
                        }
                    }
                    // ========== If request document ======================


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

                // ========== If request document ======================
                if($request->input('document')){

                    $fileHasExist = Media::where('user_id', $user->id)->get();

                    if ($fileHasExist){
                        foreach ($fileHasExist as $item){
                            if (file_exists(public_path($item->file))){
                                unlink($item->file);
                                Media::where('user_id', $user->id)->delete();
                            }
                        }
                    }

                    foreach ($request->input('document', []) as $file) {
                        Media::create([
                            'user_id' => $user->id,
                            'file' => 'uploads/documents/'.$file
                        ]);
                    }
                }
                // ========== If request document ======================


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

            // ========== If request document ======================
            if($request->input('document')){

                $fileHasExist = Media::where('user_id', $user->id)->get();

                if ($fileHasExist){
                    foreach ($fileHasExist as $item){
                        if (file_exists(public_path($item->file))){
                            unlink($item->file);
                            Media::where('user_id', $user->id)->delete();
                        }
                    }
                }

                foreach ($request->input('document', []) as $file) {
                    Media::create([
                        'user_id' => $user->id,
                        'file' => 'uploads/documents/'.$file
                    ]);
                }
            }
            // ========== If request document ======================


            // Delete previous user role
            DB::table('model_has_roles')->where('model_id',$user->id)->delete();
            $update->assignRole($request->input('roles'));
        }


        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        // If user image null
        if (!$user->image == NULL){
            // If file exist
            if (file_exists(public_path($user->image))){
                // Remove image from folder
                unlink(public_path($user->image));
                $user->delete();

                return  response()->json([
                    'success' => 1
                ]);

            }else{

                $user->delete();
                return  response()->json([
                    'success' => 1
                ]);
            }


        }else{

            $user->delete();
            return  response()->json([
                'success' => 1
            ]);
        }

    }


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




    // Store File temporary Storage
    public function storeMedia(Request $request){

        $path = public_path('uploads/documents');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        if ($request->file('file')){
            $file = $request->file('file');

//            $name = uniqid() . '_' . trim($file->getClientOriginalName());
            $name = uniqid() . '.' .$file->getClientOriginalExtension();

            $file->move($path, $name);
        }

//        $file->move(public_path('uploads/documents'), $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }


    // Upload Dropzone file
//    public function uploadStore(Request $request)
//    {
//
//        $product = User::create([
//            'name' => $request->name,
//            'email' => 'name@gmail.com',
//
//        ]);
//        foreach ($request->input('document', []) as $file) {
////            $product->addMedia(public_path('uploads/documents/'.$file))->toMediaCollection('document');
//            $product->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('document');
//        }
//        return redirect()->back();
//
//    }






}
