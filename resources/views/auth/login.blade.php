@extends('layouts.user')

@section('title', 'Login')

@section('content')
<main class="no-main">
    <div class="ps-breadcrumb">
        <div class="container">
            <ul class="ps-breadcrumb__list">
                <li class="active"><a href="/">Home</a></li>
                <li><a href="javascript:void(0);">Login</a></li>
            </ul>
        </div>
    </div>
    <section class="section--login">
        <div class="container">
            <div class="row">
                <div class="col-12 mx-auto col-md-6">
                    <div class="login__box">
                        <div class="login__header">
                            <h3 class="login__login">LOGIN</h3>
                        </div>
                        <form method="POST" class="login__content" action="{{ route('login') }}">
                            @csrf
                            <div class="text-center login__label">Login to your account.</div>
                            <div class="input-group">
                                <input class="form-control" value="{{ old('email') }}" name="email" type="email" placeholder="Email">
                            </div>
                            @error('email')
                                <div class="p-0">
                                    <strong style="color: #dc3545; font-size: 11px">{{ $message }}</strong>
                                </div>
                            @enderror
                            <div class="input-group group-password">
                                <input name="password" class="form-control" type="password" placeholder="Password">
                                <div class="input-group-append bg-white">
                                    <a href="/password/reset" class="my-auto btn forgot-pass">Forgot?</a>
                                </div>
                            </div>
                            <div class="input-group form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember" class="form-check-label">Remember me</label>
                            </div>
                            <button class="btn btn-login" type="submit">Login</button>
                            <div class="text-center small">Don't have account? <a class="forgot-pass bg-light" href="/register">Create</a>.</div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
