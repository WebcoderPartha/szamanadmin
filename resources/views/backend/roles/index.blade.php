@extends('backend.layouts.app')
@section('title', 'Productd')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <h4 class="font-weight-bold">{{ $message }}</h4>
                            </div>
                        @endif
                        <h4 class="card-title">Role List</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Permissions</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($roles as $key => $role)
                                    @php
                                        $rolePermissions = \Spatie\Permission\Models\Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")->where("role_has_permissions.role_id", $role->id)->get();
                                        $badgeColor = ['primary', 'danger', 'info', 'success', 'warning', 'secondary']
                                    @endphp
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @if (!empty($rolePermissions))
                                                @foreach($rolePermissions as $perKey => $permission)
                                                    <span class="badge badge-{{$badgeColor[$perKey]}} px-2">{{$permission->name}}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                                @can('role-edit')
                                                    <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">Edit</a>
                                                @endcan
                                                @csrf
                                                @method('DELETE')
                                                @can('role-delete')
                                                    <button type="submit" onclick="return confirm('Are you sure to delete?')" class="btn btn-danger">Delete</button>
                                                @endcan
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
