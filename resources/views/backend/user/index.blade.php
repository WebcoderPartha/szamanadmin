@extends('backend.layouts.app')
@section('title', 'User List')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                            <table class="table table-striped table-bordered zero-configuration  data-table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Profession</th>
                                    <th>Nationality</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
{{--                                @foreach ($users as $key => $user)--}}

{{--                                    <tr>--}}
{{--                                        <td>{{ $key+1 }}</td>--}}
{{--                                        <td>{{ $user->name }}</td>--}}
{{--                                        <td> {{ $user->email }} </td>--}}
{{--                                        <td> {{ $user->gender }} </td>--}}
{{--                                        <td> {{ $user->profession }} </td>--}}
{{--                                        <td> {{ $user->nationality }} </td>--}}
{{--                                        <td>--}}
{{--                                            @if(!empty($user->getRoleNames()))--}}
{{--                                                @foreach($user->getRoleNames() as $role)--}}
{{--                                                    <label class="badge badge-info">{{ $role }}</label>--}}
{{--                                                @endforeach--}}
{{--                                            @endif--}}
{{--                                        </td>--}}

{{--                                        <td>--}}
{{--                                            @if($user->status == 1)--}}
{{--                                                <span class="badge badge-success px-2">Active</span>--}}
{{--                                            @else--}}
{{--                                                <span class="badge badge-danger px-2">Deactive</span>--}}
{{--                                            @endif--}}

{{--                                        </td>--}}
{{--                                        <th> @if($user->image !== null )--}}
{{--                                                <img src="{{ asset($user->image) }}" width="80" alt="">--}}
{{--                                            @else--}}
{{--                                                <img src="{{ asset('uploads/profile/profile.jpg') }}" width="80" alt="">--}}
{{--                                            @endif--}}
{{--                                        </th>--}}
{{--                                        <td>--}}
{{--                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">--}}
{{--                                                @can('role-edit')--}}
{{--                                                    <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Edit</a>--}}
{{--                                                @endcan--}}
{{--                                                @csrf--}}
{{--                                                @method('DELETE')--}}
{{--                                                @can('role-delete')--}}
{{--                                                    <button type="submit" onclick="return confirm('Are you sure to delete?')" class="btn btn-danger">Delete</button>--}}
{{--                                                @endcan--}}
{{--                                            </form>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}

{{--                                @endforeach--}}

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(function () {
            $.noConflict();
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'gender', name: 'gender'},
                    {data: 'profession', name: 'profession'},
                    {data: 'nationality', name: 'nationality'},
                    {data: 'status', name: 'status'},
                    {data: 'image', name: 'image'},
                    {data: 'action', name: 'action', orderable: true, searchable: true},
                ]
            });

        });
    </script>

@endsection
