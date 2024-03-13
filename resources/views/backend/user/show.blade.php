@extends('backend.layouts.app')
@section('title', 'View User')
@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">User View</a></li>
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
                                            @if($user[0]->image !== null)
                                                <img class="text-center img-circle" src="{{ asset($user[0]->image) }}" width="200" alt="">
                                            @else
                                                <img class="text-center img-circle" src="{{ asset('uploads/profile/profile.jpg') }}" width="200" alt="">
                                            @endif
                                        </div>
                                        <div>
                                            <h4>Documents</h4>
                                            @if(count($user[0]->media) > 0)
                                                @foreach($user[0]->media as $document)
                                                    <a download href="{{ asset($document->file) }}"><img width="35" src="{{ asset('backend/images/file.jpg') }}" alt=""></a>
                                                @endforeach
                                            @endif
                                        </div>

                                    </div>

                                    <div class="col-8">
                                        <h4>User Details</h4>
                                        <table class="table">
                                            <tr>
                                                <td>Name:</td>
                                                <td><b>{{ $user[0]->name }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Profession:</td>
                                                <td><b>{{ $user[0]->profession }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Email:</td>
                                                <td><b>{{ $user[0]->email }}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Gender:</td>
                                                <td><b>{{ $user[0]->gender }}</b></td>
                                            </tr>
                                            @if($user[0]->nationality !== null)
                                                <tr>
                                                    <td>Nationality:</td>
                                                    <td><b>{{ $user[0]->nationality }}</b></td>
                                                </tr>
                                            @endif
                                            @if($user[0]->remarks !== null)
                                                <tr>
                                                    <td>Remarks:</td>
                                                    <td><b>{{ $user[0]->remarks }}</b></td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>Role:</td>
                                                <td>
                                                    @if(!empty($user[0]->getRoleNames()))
                                                        @foreach ($user[0]->getRoleNames() as $role)
                                                            <label class="badge badge-info">{{ $role }}</label>
                                                        @endforeach
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Status:</td>
                                                <td>
                                                    @if($user[0]->status === '1')
                                                        <span class="badge badge-success px-2">Active</span>
                                                    @else
                                                        <span class="badge badge-danger px-2">Inactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

-
    <!-- #/ container -->

@endsection
