@extends('layouts.user')

@section('title', 'Wishlist')

@section('content')

<main class="no-main">
    <div class="ps-breadcrumb">
        <div class="container">
            <ul class="ps-breadcrumb__list">
                <li class="active"><a href="/">Home</a></li>
                <li class="active"><a href="/shop">Shop</a></li>
                <li><a href="javascript:void(0);">Wishlist</a></li>
            </ul>
        </div>
    </div>
    <section class="section--wishlist">
        <div class="container">
            <h2 class="page__title">Wishlist</h2>
            <div class="wishlist__content">
                <div class="wishlist__product">
                    <div class="wishlist__product--mobile">
                        <div class="row m-0 wishlist__product--mobile-products">
                        </div>
                    </div>
                    <div class="wishlist__product--desktop">
                        <table class="table">
                            <thead class="wishlist__thead">
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Stock Status</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="wishlist__tbody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
