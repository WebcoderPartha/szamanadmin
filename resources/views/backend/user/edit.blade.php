@extends('backend.layouts.app')
@section('title', 'Update')
@section('content')
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">User List</a></li>
            </ol>
        </div>
    </div>
    <!-- row -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <h4 class="font-weight-bold">{{ $message }}</h4>
                            </div>
                        @endif
                        <form action="{{ route('users.update', $user->id) }}" method="POST" class="step-form-horizontal" enctype="multipart/form-data">
                            @method("PUT")
                            @csrf
                            <div>
                                <h4>Create User</h4>
                                <section>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Name">
                                                @error('name')
                                                <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="email" name="email" value="{{ $user->email }}" class="form-control" placeholder="Email">
                                                @error('email')
                                                <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control" placeholder="Password">
                                                @error('password')
                                                <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                                                @error('password_confirmation')
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
                                                    <input type="radio" name="gender" @if($user->gender === 'Male') checked @endif value="Male"> Male</label>
                                                <label class="radio-inline mr-3">
                                                    <input type="radio" value="Female" @if($user->gender === 'Female') checked @endif name="gender"> Female</label>
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
                                                        <input type="checkbox" name="profession" class="form-check-input inputcheck" @if($user->profession === 'Engineer') checked @endif   value="Engineer">Engineer</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="profession" class="form-check-input inputcheck" @if($user->profession === 'Doctor') checked @endif value="Doctor">Doctor</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox"  name="profession" class="form-check-input inputcheck" @if($user->profession === 'Professor') checked @endif value="Professor">Professor</label>

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
                                                    <option value="1" @if($user->status === '1') selected @endif>Active</option>
                                                    <option value="0" @if($user->status === '0') selected @endif>Deactive</option>
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

                                                        <option value="{{ $role->name }}" {{ $user->roles->contains($role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('roles')
                                                <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <h6> <label for="nationality">Nationality</label></h6>
                                                <select id="nationality" name="nationality" class="form-control">
                                                    <option value="">Choose nationality</option>
                                                </select>
                                                @error('nationality')
                                                <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <section>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <h6> <label for="remarks">Remarks</label></h6>
                                                <textarea name="remarks" class="form-control" id="" cols="30" rows="5">{{ $user->remarks }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <h6> <label for="image">Image</label></h6>
                                                        <input id="image" class="form-control-file" type="file" name="image">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <img src="{{ asset($user->image) }}" id="imagePreview" width="100" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <div class="row h-100">
                                        <div class="col-12 h-100 d-flex flex-column justify-content-center align-items-center">
                                            <input type="submit" class="btn btn-primary" value="Update User">
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

        })
    </script>
@endsection
