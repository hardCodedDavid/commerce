@extends('layouts.user')

@section('title', 'Forgot Password')

@section('content')

<main class="no-main">
    <div class="ps-breadcrumb">
        <div class="container">
            <ul class="ps-breadcrumb__list">
                <li class="active"><a href="/">Home</a></li>
                <li><a href="javascript:void(0);">Forgot Password</a></li>
            </ul>
        </div>
    </div>
    <section class="section--login">
        <div class="container">
            <div class="row">
                <div class="col-12 mx-auto col-md-6">
                    <div class="login__box">
                        <div class="login__header">
                            <h3 class="login__login">RESET PASSWORD</h3>
                        </div>
                        <form method="POST" class="login__content" action="{{ route('password.email') }}">
                            @csrf
                            <div class="text-center login__label">Forgot your password? Reset here</div>

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="input-group">
                                <input class="form-control" value="{{ old('email') }}" name="email" type="email" placeholder="Email">
                            </div>
                            @error('email')
                                <div class="p-0">
                                    <strong style="color: #dc3545; font-size: 11px">{{ $message }}</strong>
                                </div>
                            @enderror
                            <button class="btn btn-login" type="submit">Send Password Reset Link</button>
                            <div class="text-center small">Remember password? <a class="forgot-pass bg-light" href="/login">login</a>.</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
