@extends('backend.layouts.app')
@section('title', 'Create')
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
                        <form action="#" class="step-form-horizontal" enctype="multipart/form-data">
                            <div>
                                <h4>Create User</h4>
                                <section>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="text" name="name" class="form-control" placeholder="Name" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="password" name=password" class="form-control" placeholder="Password" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
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
                                                    <input type="radio" name="gender" value="Male">Male</label>
                                                <label class="radio-inline mr-3">
                                                    <input type="radio" value="Female" name="gender">Female</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <h6 class="card-title">Profession</h6>
                                            <div class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="profession" class="form-check-input" value="Engineer">Engineer</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox" name="profession" class="form-check-input" value="">Doctor</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="checkbox"  name="profession" class="form-check-input" value="">Professor</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <h6> <label for="status">Status</label></h6>
                                                <select id="status" name="status" class="form-control">
                                                    <option selected="selected">Choose</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Deactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <h6> <label for="nationality">Nationality</label></h6>
                                                <select id="nationality" name="nationality" class="form-control">
                                                    <option selected="selected">Choose</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <section>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <h6> <label for="remarks">Remarks</label></h6>
                                                <textarea name="remarks" class="form-control" id="" cols="30" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <h6> <label for="image">Image</label></h6>
                                                <input id="image" class="form-control-file" type="file" name="image">
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <section>
                                    <div class="row h-100">
                                        <div class="col-12 h-100 d-flex flex-column justify-content-center align-items-center">
                                            <input type="submit" class="btn btn-primary" value="Add User">
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

            {{--$('#nationality').on('change', function () {--}}
            {{--    var country = this.value;--}}
            {{--    $("#state-dropdown").html('');--}}
            {{--    $.ajax({--}}
            {{--        url: "https://restcountries.com/v3.1/all",--}}
            {{--        type: "GET",--}}
            {{--        data: {--}}
            {{--            country: country,--}}
            {{--            _token: '{{csrf_token()}}'--}}
            {{--        },--}}
            {{--        dataType: 'json',--}}
            {{--        success: function (result) {--}}
            {{--            console.log(result[0])--}}
            {{--            // $('#state-dropdown').html('<option value="">-- Select State --</option>');--}}
            {{--            // $.each(result.states, function (key, value) {--}}
            {{--            //     $("#state-dropdown").append('<option value="' + value--}}
            {{--            //         .id + '">' + value.name + '</option>');--}}
            {{--            // });--}}
            {{--            // $('#city-dropdown').html('<option value="">-- Select City --</option>');--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}

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
            })

        })
    </script>
@endsection
