@extends('backend.layouts.app')
@section('title', 'User List')
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
                        <h4 class="card-title">User List</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Profession</th>
                                    <th>Nationality</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $key => $user)

                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td> {{ $user->email }} </td>
                                        <td> {{ $user->gender }} </td>
                                        <td> {{ $user->profession }} </td>
                                        <td> {{ $user->nationality }} </td>
                                        <td>
                                            @if(!empty($user->getRoleNames()))
                                                @foreach($user->getRoleNames() as $role)
                                                    <label class="badge badge-info">{{ $role }}</label>
                                                @endforeach
                                            @endif
                                        </td>

                                        <td>
                                            @if($user->status == 1)
                                                <span class="badge badge-success px-2">Active</span>
                                            @else
                                                <span class="badge badge-danger px-2">Deactive</span>
                                            @endif

                                        </td>
                                        <th> @if($user->image !== null )
                                                <img src="{{ asset($user->image) }}" width="80" alt="">
                                            @else
                                                <img src="{{ asset('uploads/profile/profile.jpg') }}" width="80" alt="">
                                            @endif
                                        </th>
                                        <td>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                @can('role-edit')
                                                    <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Edit</a>
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
