@extends('backend.layouts.app')
@section('title', 'Add Permission')
@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Permission</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" action="{{route('admin.permission.store')}}">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add Permission</h4>
                            <div class="basic-form">
                                <div class="form-group">
                                    <input type="text" class="form-control input-default" name="name" placeholder="Example:User">
                                    @error('name')
                                    <small class="text-red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-dark">Save</button>
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
