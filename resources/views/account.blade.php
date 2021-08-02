@extends('layouts.user')

@section('title', 'Account')

@section('styles')
    <link rel="stylesheet" href="/css/style.css">
@endsection

@php
    $user = auth()->user();
    $name = $user['name'] ?? null;
    $country = $user['country'] ?? null;
    $state = $user['state'] ?? null;
    $address = $user['address'] ?? null;
    $postcode = $user['postcode'] ?? null;
    $city = $user['city'] ?? null;
    $phone = $user['phone'] ?? null;
    $email = $user['email'] ?? null;
@endphp

@section('content')
<main class="ps-page--my-account">
    <section class="ps-section--account">
        <div class="container">
            <div class="row mt-lg-0 mt-5">
                @include('account-sidebar', ['active' => 'account'])
                <div class="col-lg-8">
                    <div class="ps-section__right">
                        <form class="ps-form--account-setting mb-5" action="{{ route('account.update') }}" method="POST">
                            @csrf
                            <div class="ps-form__header">
                                <h3> User Information</h3>
                            </div>
                            <div class="ps-form__content row">
                                <div class="col-lg-6 form-group--block">
                                    <label>Full Name: <span>*</span></label>
                                    <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $name }}" type="text" placeholder="Full Name">
                                    @error('name')
                                        <div class="small">
                                            <strong style="color: red">{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 form-group--block">
                                    <label>Email address: <span>*</span></label>
                                    <input class="form-control" value="{{ old('email') ?? $email }}" type="email" disabled>
                                </div>
                                <div class="col-lg-6 form-group--block">
                                    <label>Country: <span>*</span></label>
                                    <input class="form-control @error('country') is-invalid @enderror" name="country" value="{{ old('country') ?? $country }}" type="text" placeholder="Country">
                                    @error('country')
                                        <div class="small">
                                            <strong style="color: red">{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 form-group--block">
                                    <label>State: <span>*</span></label>
                                    <input class="form-control @error('state') is-invalid @enderror" name="state" value="{{ old('state') ?? $state }}" type="text" placeholder="State">
                                    @error('state')
                                        <div class="small">
                                            <strong style="color: red">{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 form-group--block">
                                    <label>Address: <span>*</span></label>
                                    <input class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') ?? $address }}" type="text" placeholder="Address">
                                    @error('address')
                                        <div class="small">
                                            <strong style="color: red">{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 form-group--block">
                                    <label>Postcode/ ZIP (optional)</label>
                                    <input class="form-control" name="postcode" value="{{ old('postcode') ?? $postcode }}" type="text">
                                </div>
                                <div class="col-lg-6 form-group--block">
                                    <label>Town/ City: <span>*</span></label>
                                    <input class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') ?? $city }}" type="text">
                                    @error('city')
                                        <div class="small">
                                            <strong style="color: red">{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 form-group--block">
                                    <label>Phone: <span>*</span></label>
                                    <input class="form-control @error('phone') is-invalid @enderror"  name="phone" value="{{ old('phone') ?? $phone }}" type="text">
                                    @error('phone')
                                        <div class="small">
                                            <strong style="color: red">{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group submit mt-4">
                                <button class="ps-btn">Update</button>
                            </div>
                        </form>
                        <hr>
                        <form class="ps-form--account-setting mt-5" action="{{ route('password.custom.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="ps-form__header">
                                <h3> Change Password</h3>
                            </div>
                            <div class="ps-form__content row">
                                <div class="col-lg-12 form-group--block">
                                    <label>Old Password: <span>*</span></label>
                                    <input class="form-control @error('old_password') is-invalid @enderror" name="old_password" type="password" placeholder="Old Password">
                                    @error('old_password')
                                        <div class="small">
                                            <strong style="color: red">{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="ps-form__content row">
                                <div class="col-lg-6 form-group--block">
                                    <label>New Password: <span>*</span></label>
                                    <input class="form-control @error('new_password') is-invalid @enderror" name="new_password" type="password" placeholder="New Password">
                                    @error('new_password')
                                        <div class="small">
                                            <strong style="color: red">{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-lg-6 form-group--block">
                                    <label>Confirm New Password: <span>*</span></label>
                                    <input class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation" type="password" placeholder="Confirm New Password">
                                    @error('new_password_confirmation')
                                        <div class="small">
                                            <strong style="color: red">{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group submit mt-4">
                                <button class="ps-btn">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection