@extends('layouts.user')

@section('title', 'Reset Password')

@section('content')

<main class="no-main">
    <div class="ps-breadcrumb">
        <div class="container">
            <ul class="ps-breadcrumb__list">
                <li class="active"><a href="/">Home</a></li>
                <li><a href="javascript:void(0);">Reset Password</a></li>
            </ul>
        </div>
    </div>
    <section class="section--login">
        <div class="container">
            <div class="row">
                <div class="col-12 mx-auto col-md-6">
                    <div class="login__box">
                        <div class="login__header">
                            <h3 class="login__login">Reset Password</h3>
                        </div>
                        <form method="POST" class="login__content" action="{{ route('password.update') }}">
                            @csrf
                            <div class="text-center login__label">Reset your password.</div>
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="input-group">
                                <input class="form-control" value="{{ $email ?? old('email') }}" name="email" type="email" placeholder="Email">
                            </div>
                            @error('email')
                                <div class="p-0">
                                    <strong style="color: #dc3545; font-size: 11px">{{ $message }}</strong>
                                </div>
                            @enderror
                            <div class="input-group group-password">
                                <input name="password" class="form-control" type="password" placeholder="Password">
                            </div>
                            @error('password')
                                <div class="p-0">
                                    <strong style="color: #dc3545; font-size: 11px">{{ $message }}</strong>
                                </div>
                            @enderror
                            <div class="input-group group-password">
                                <input name="password_confirmation" class="form-control" type="password" placeholder="Confirm Password">
                            </div>
                            <button class="btn btn-login" type="submit">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
