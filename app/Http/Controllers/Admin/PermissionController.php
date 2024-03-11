<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\Datatables;


class PermissionController extends Controller
{

    public $permissions = [
        'list',
        'create',
        'edit',
        'delete',
    ];


    public function index(Request $request){
        if ($request->ajax()) {
            $data = Permission::all();
            return Datatables::of($data)

                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm editUser" data-id="'.$row->id.'">Edit</a> <a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn deleteUser btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.permission.list');
    }



    public function create(){
        return view('backend.permission.create');
    }

    public function store(Request $request){

        $validate = $request->validate([
           'name' => 'required|string'
        ]);

        foreach ($this->permissions as $permission){
            Permission::create([
                'name' =>  Str::lower($request->name).'-'.$permission
            ]);
        }

        return redirect()->route('admin.permission.index')->with('success', 'Permission updated successfully');

    }

    public function edit($id){

        $permission = Permission::findById($id);
        return view('backend.permission.edit', compact('permission'));

    }

    public function update(Request $request, $id){

        Permission::findById($id)->update([
            'name' => Str::of($request->name)->lower()->slug('-')
        ]);
        return redirect()->route('admin.permission.index')->with('success', 'Permission updated successfully');
    }


    public function delete(Request $request){
        Permission::findById($request->id)->delete();
        return  response()->json([
            'success' => 1
        ]);
    }


}
