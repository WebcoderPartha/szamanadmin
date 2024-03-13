@extends('backend.layouts.app')
@section('title', 'Permission List')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <div class="container-fluid">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 offset-3">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <h4 class="font-weight-bold">{{ $message }}</h4>
                            </div>
                        @endif
                        <h4 class="card-title">Permission List</h4>
                        <div class="table-responsive">
                            <table id="permissionTable" class="table table-striped table-bordered zero-configuration data-table">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Permission</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

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
                ajax: "{{ route('admin.permission.index') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'action', name: 'action', orderable: true, searchable: true},
                ]
            });


            // Edit User Button
            $('#permissionTable').on('click','.editUser',function(){
                let id = $(this).data('id');
                window.location.href = "permissions/"+id+"/edit";
            })

            // Delete record
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $('#permissionTable').on('click','.deleteUser',function() {
                let id = $(this).data('id');

                var deleteConfirm = confirm("Are you sure?");
                if (deleteConfirm === true) {
                    // AJAX request
                    $.ajax({
                        url: "{{ route('admin.permission.delete') }}",
                        type: 'post',
                        data: {_token: CSRF_TOKEN, id: id},
                        success: function (response) {
                            if (response.success == 1) {
                                alert("Record deleted.");

                                // Reload DataTable
                                table.ajax.reload();
                            } else {
                                alert("Invalid ID.");
                            }
                        }
                    });
                }
            })

        });

    </script>

@endsection
