@extends('layouts.user')

@section('title', 'Orders')

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
                @include('account-sidebar', ['active' => 'orders'])
                <div class="col-lg-8">
                    <div class="ps-section__right">
                        <form class="ps-form--account-setting" action="http://nouthemes.net/html/martfury/index.html" method="get">
                            <div class="ps-form__header">
                                <h3> Orders</h3>
                            </div>
                            <div class="ps-form__content table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>#</th>
                                        <th>Order ID</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection