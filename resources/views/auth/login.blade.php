@extends('layouts.auth')
@section('login')
    <div class="login-box">

        <!-- /.login-logo -->
        <div class="login-box-body">
            <div class="login-logo">
                <a href="{{ url('/') }}"><b>Admin</b>LTE</a>
            </div>

            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="form-group has-feedback has-error"
                    @error('email')
                    has-error value="{{ old('email') }}"
                @enderror>
                    <input type="email" name="email" class="form-control" placeholder="Email" required
                        value="{{ old('email') }}" autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @error('email')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group has-feedback has-error">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @error('password')
                        <span class="help-block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox"> Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>



            {{-- <a href="#">I forgot my password</a><br>
            <a href="register.html" class="text-center">Register a new membership</a> --}}

        </div>
        <!-- /.login-box-body -->
    </div>
@endsection
