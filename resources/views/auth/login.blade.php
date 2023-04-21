@extends('layouts.app')

@section('content')

<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>
  
        <form action="{{ route('login') }}" method="post">
            @csrf

          <div class="input-group mb-3">
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus >
            
            @error('email')
                <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-envelope">
                        {{ $message }}
                      </span>
                    </div>
                </div>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required autocomplete="current-password">
     
            @error('password')
                <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock">
                        {{ $message }}
                      </span>
                    </div>
                </div>
            @enderror
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} >
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                {{-- @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif --}}
            </div>
            <!-- /.col -->
          </div>
        </form>
  
        <div class="social-auth-links text-center mt-2 mb-3">
          <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
          </a>
        </div>
        <!-- /.social-auth-links -->
  
        <p class="mb-1">
          <a href="{{ route('password.request') }}">I forgot my password</a>
        </p>
        <p class="mb-0">
          <a href="register.html" class="text-center">Register a new membership</a>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

@endsection
