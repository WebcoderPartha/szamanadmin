@extends('backend.layouts.app')
@section('title', 'Create')
@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Role</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" action="{{route('roles.update', $role->id)}}">
                    @method('PUT')
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Edit Role</h4>
                            <div class="basic-form">
                                <div class="form-group">
                                    <input type="text" class="form-control input-default" value="{{ $role->name }}" name="name" placeholder="Role name">
                                    @error('name')
                                        <small class="text-red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <h4 class="card-title">Edit Permissions</h4>

                            <div class="basic-form">
                                <div class="form-group">
                                    @foreach ($permission as $permissionValue)
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" @if (in_array($permissionValue->id, $rolePermissions)) checked @endif name="permission[]" value="{{ $permissionValue->id }}">{{ $permissionValue->name }}</label>
                                        </div>
                                    @endforeach
                                    @error('permission')
                                        <br>
                                        <small class="text-red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-dark">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- #/ container -->
@endsection
