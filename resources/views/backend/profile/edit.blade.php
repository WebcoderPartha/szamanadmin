@extends('backend.layouts.app')
@section('title', 'Create')
@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-3">
                <div class="card">
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <h4 class="font-weight-bold">{{ $message }}</h4>
                            </div>
                        @endif
                        <form id="userCreatForm" action="{{ route('users.store') }}" method="POST" class="step-form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <h4>Profile</h4>
                                <section>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" placeholder="Name">
                                                @error('name')
                                                <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control" placeholder="Email">
                                                @error('email')
                                                <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h6>Gender</h6>
                                            <div class="form-group">
                                                <label class="radio-inline mr-3">
                                                    <input type="radio" name="gender" value="Male"> Male</label>
                                                <label class="radio-inline mr-3">
                                                    <input type="radio" value="Female" name="gender"> Female</label>
                                            </div>
                                            @error('gender')
                                            <small class="text-red">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-lg-6">
                                            <h6 class="card-title">Profession</h6>
                                            <div class="form-group" id="professionCheckbox">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label" >
                                                        <input type="checkbox" name="profession" class="form-check-input inputcheck"   value="Engineer">Engineer</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="profession" class="form-check-input inputcheck" value="Doctor">Doctor</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox"  name="profession" class="form-check-input inputcheck" value="Professor">Professor</label>

                                                </div>

                                                @error('profession')
                                                <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <h6> <label for="status">Status</label></h6>
                                                <select id="status" name="status" class="form-control">
                                                    <option value="">Choose status</option>
                                                    <option value="1" @if(Auth::user()->status === '1') selected @endif>Active</option>
                                                    <option value="0" @if(Auth::user()->status === '0') selected @endif>Deactive</option>
                                                </select>
                                                @error('status')
                                                <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <h6> <label for="roles">Role</label></h6>
                                                <select id="roles" class="form-control" name="roles">
                                                    <option value="">Choose role</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role }}" >{{ $role }}</option>
                                                    @endforeach
                                                </select>
                                                @error('roles')
                                                <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </section>

                                <section>
                                    <div class="row">

                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <h6> <label for="image">Image</label></h6>
                                                        <input id="image" class="form-control-file" type="file" name="image">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <img src="" id="imagePreview" width="100" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <div class="row h-100">
                                        <div class="col-12 h-100 d-flex flex-column justify-content-center align-items-center">
                                            <input type="submit" class="btn btn-primary" value="Update Profile">
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>



        $(document).ready(function () {

            // Profession CheckBox
            $(".form-check-input").click(function(){
                $(".form-check-input").not(this).prop("checked", false);
            })

            // Country Fetch From API
            $("#nationality").on("click", function(){
                // event.preventDefault()
                $.ajax({
                    method: "GET",
                    url: "https://restcountries.com/v3.1/all",
                    dataType: "json",
                    success: function(response) {
                        if(response.length > 0) {
                            response.forEach(el => {
                                $("#nationality").append(`<option value='${el.name.common}'> ${el.name.common}</option>`)
                                console.log(el.name.common)
                            })
                        }
                    },
                    error: function(error) {
                        console.log(error)
                    }
                })
                $("#addSN").hide()
            });

            // Image Preview
            $('#image').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#imagePreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

        });
    </script>
@endsection
