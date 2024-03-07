@extends('backend.layouts.auth')
@section('title', 'Login Page')
@section('content')
    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <h4 class="text-center">SZamanTech</h4>
                                <form action="{{ route('admin.login.action') }}" class="mt-5 mb-5 login-input" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email">
                                        @error('email')
                                            <small class="text-red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" value="{{ old('password') }}" class="form-control" placeholder="Password">
                                        @error('email')
                                            <small class="text-red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn login-form__btn submit w-100">Sign In</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
