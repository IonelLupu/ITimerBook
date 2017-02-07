@extends('Dashboard::layouts.auth')

@section('content')

    <div class="login-box">
        <div class="login-logo">
            <h1><b>Admin</b></h1>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <h2><p class="login-box-msg">Sign in</p></h2>

            <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/login') }}">
                {{ csrf_field() }}
                <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }} ">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-Mail Address">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                    @if ($errors->has('email'))
                        <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group  has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                    <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                    @if ($errors->has('password'))
                        <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="row">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="remember"> Remember Me
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

            <!-- /.social-auth-links -->
            <a class="btn btn-link" href="{{ url('dashboard/password/reset') }}">Forgot Your Password?</a><br>
            <a href="{{ url('dashboard/register') }}" class="btn btn-link">Register</a>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

@endsection
