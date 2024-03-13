@extends('backend.layouts.app')
@section('title', $user->name.' | Profile')
@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile Details</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6 offset-3">
                        <div class="row">
                            <div class="col-4">
                                <div class="media align-items-center mb-4">
                                    @if($user->image !== null)
                                        <img class="text-center img-circle" src="{{ asset($user->image) }}" width="200" alt="">
                                    @else
                                        <img class="text-center img-circle" src="{{ asset('uploads/profile/profile.jpg') }}" width="200" alt="">
                                    @endif
                                </div>

                            </div>
                            <div class="col-8">
                                <h4>User Details</h4>
                                <table class="table">
                                    <tr>
                                        <td>Name:</td>
                                        <td><b>{{ $user->name }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Profession:</td>
                                        <td><b>{{ $user->profession }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td><b>{{ $user->email }}</b></td>
                                    </tr>
                                    <tr>
                                        <td>Gender:</td>
                                        <td><b>{{ $user->gender }}</b></td>
                                    </tr>
                                    @if($user->nationality !== null)
                                        <tr>
                                            <td>Nationality:</td>
                                            <td><b>{{ $user->nationality }}</b></td>
                                        </tr>
                                    @endif
                                    @if($user->remarks !== null)
                                        <tr>
                                            <td>Remarks:</td>
                                            <td><b>{{ $user->remarks }}</b></td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>Role:</td>
                                        <td>
                                            @if(!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $role)
                                                    <label class="badge badge-info">{{ $role }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status:</td>
                                        <td>
                                            @if($user->status === '1')
                                                <span class="badge badge-success px-2">Active</span>
                                            @else
                                                <span class="badge badge-danger px-2">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>

                                </table>
                                <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- #/ container -->
@endsection
