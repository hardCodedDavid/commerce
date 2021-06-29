@extends('layouts.auth.admin')

@section('title', 'Reset Password')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.password.update') }}" method="POST">
            @csrf
            <h4 class="text-primary my-4">Reset Password</h4>
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="text-left invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="text-left invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input id="password" type="password" placeholder="Confirm Password" class="form-control" name="password_confirmation" required>
            </div>
          <button type="submit" class="btn btn-success btn-lg btn-block font-18">Reset Password</button>
        </form>
    </div>
</div>
@endsection
