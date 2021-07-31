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
            <div class="row">
                @include('account-sidebar', ['active' => 'account'])
                <div class="col-lg-8">
                    <div class="ps-section__right">
                        <form class="ps-form--account-setting" action="http://nouthemes.net/html/martfury/index.html" method="get">
                            <div class="ps-form__header">
                                <h3> User Information</h3>
                            </div>
                            <div class="ps-form__content row">
                                <div class="col-lg-6 form-group--block">
                                    <label>Full Name: <span>*</span></label>
                                    <input class="form-control" value="{{ old('name') ?? $name }}" type="text" placeholder="Full Name">
                                </div>
                                <div class="col-lg-6 form-group--block">
                                    <label>Email address: <span>*</span></label>
                                    <input class="form-control" value="{{ old('email') ?? $email }}" type="email" disabled>
                                </div>
                                <div class="col-lg-6 form-group--block">
                                    <label>Country: <span>*</span></label>
                                    <input class="form-control" value="{{ old('country') ?? $country }}" type="text" placeholder="Country">
                                </div>
                                <div class="col-lg-6 form-group--block">
                                    <label>State: <span>*</span></label>
                                    <input class="form-control" value="{{ old('state') ?? $state }}" type="text" placeholder="State">
                                </div>
                                <div class="col-lg-6 form-group--block">
                                    <label>Address: <span>*</span></label>
                                    <input class="form-control" value="{{ old('address') ?? $address }}" type="text" placeholder="Address">
                                </div>
                                <div class="col-lg-6 form-group--block">
                                    <label>Postcode/ ZIP (optional)</label>
                                    <input class="form-control" value="{{ old('postcode') ?? $postcode }}" type="text">
                                </div>
                                <div class="col-lg-6 form-group--block">
                                    <label>Town/ City: <span>*</span></label>
                                    <input class="form-control" value="{{ old('city') ?? $city }}" type="text" required>
                                </div>
                                <div class="col-lg-6 form-group--block">
                                    <label>Phone: <span>*</span></label>
                                    <input class="form-control" value="{{ old('phone') ?? $phone }}" type="text" required>
                                </div>
                            </div>
                            <div class="form-group submit mt-4">
                                <button class="ps-btn">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection