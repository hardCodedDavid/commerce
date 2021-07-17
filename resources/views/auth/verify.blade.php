@extends('layouts.user')

@section('title', 'Verify Email')

@section('content')

<main class="no-main">
    <div class="ps-breadcrumb">
        <div class="container">
            <ul class="ps-breadcrumb__list">
                <li class="active"><a href="/">Home</a></li>
                <li><a href="javascript:void(0);">Register</a></li>
            </ul>
        </div>
    </div>
    <section class="section--login">
        <div class="container">
            <div class="row">
                <div class="col-12 mx-auto col-md-8">
                    <div class="login__box" style="max-width: 100%">
                        <div class="login__header">
                            <h3 class="login__login">Verify Your Email Address</h3>
                        </div>
                        <div class="login__content">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            {{ __('If you did not receive the email') }},
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" style="font-size: 14px" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
