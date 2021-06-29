@extends('layouts.auth.admin')

@section('title', 'Login')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <h4 class="text-primary my-4">Log in !</h4>
            <div class="form-group">
                <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="text-left invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
            </div>
            <div class="form-row mb-3">
                <div class="col-12">
                    <div class="custom-control custom-checkbox text-left">
                      <input class="custom-control-input" type="checkbox" name="remember" id="rememberme" {{ old('remember') ? 'checked' : '' }}>
                      <label class="custom-control-label font-14" for="rememberme">Remember Me</label>
                    </div>
                </div>
            </div>
          <button type="submit" class="btn btn-success btn-lg btn-block font-18">Log in</button>
        </form>
        <div class="login-or">
            <h6 class="text-muted">OR</h6>
        </div>
        <p class="mb-0 mt-3">Forgot your password? <a href="{{ route('admin.password.email') }}">Reset here</a></p>
    </div>
</div>
@endsection
