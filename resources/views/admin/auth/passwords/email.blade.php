@extends('layouts.auth.admin')

@section('title', 'Forgot Password')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.password.email') }}" method="POST">
            @csrf
            <h4 class="text-primary my-4">Forgot Password ?</h4>
            <p class="mb-4">Enter the email address below to receive reset password instructions.</p>
            @if (session('status'))
            <div class="alert text-left alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <div class="form-group">
                <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="text-left invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
          <button type="submit" class="btn btn-success btn-lg btn-block font-18">Send Password Reset Link</button>
        </form>
        <p class="mb-0 mt-3">Remember Password? <a href="{{ route('admin.login') }}">Log in</a></p>
    </div>
</div>
@endsection
