@extends('layouts.user')

@section('title', 'FAQs')

@section('content')
<main class="no-main">
    <section class="section--faq ps-page--business">
        <div class="container">
            <h2 class="page__title">FAQs</h2>
            <div class="faq__content">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="faq__category">
                            <ul class="nav nav-tabs">
                                <li><a class="active" data-toggle="tab" href="#order">ORDER INFORMATION</a></li>
                                <li><a data-toggle="tab" href="#shipping">SHIPPING</a></li>
                                <li><a data-toggle="tab" href="#cancellation">RETURN & CANCELLATION</a></li>
                            </ul>
                            <p>Need more help?</p>
                            <button class="btn"><a href="mailto:{{ \App\Models\Setting::first()['email'] }}"> <i class="icon-envelope"></i>Contact Us</a></button>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="order">
                                <div class="row">
                                    <div class="col-12 col-lg-6 faq__colLeft">
                                        <div class="faq__item">
                                            <h5 class="faq__question">What is my order status?</h5>
                                            <p class="faq__answer">You can view your order status by looking up your order.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">What payments do you accept?</h5>
                                            <p class="faq__answer">We accept Visa, MasterCard, Discover, American Express and check cards or ATM cards, as long as they are connected with one of the major credit card companies listed above. You can safely enter your entire credit card number via our secure server, which encrypts all submitted information.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">What is PayPal Credit?</h5>
                                            <p class="faq__answer">Checkout fast with PayPal Credit. The effortless way to pay without using your credit card. Simply select PayPal Credit at checkout, answer two simple questions and accept the terms. It's that easy. There is no separate application process. PayPal Credit offers flexible terms that allow you to choose to pay in full or over time. Subject to credit approval. <span class='text-success'>See Terms.</span></p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">How do I enter a shipping address?</h5>
                                            <p class="faq__answer">A shipping infomation page will be presented where you can enter a separate shipping address and the shipping method can be chosen.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">Should I put spaces or dashes in the credit card number?</h5>
                                            <p class="faq__answer">Your card number should be entered in as a continuous strng of numbers.</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 faq__colRight">
                                        <div class="faq__item">
                                            <h5 class="faq__question">Why are you not accepting my credit card?</h5>
                                            <p class="faq__answer">There are many reasons for a failed credit card transaction. Your card may have expired or reached its limit or a credit card computer, either on our end or your bank's end, may have encountered a machine error.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">When will my credit card charged?</h5>
                                            <p class="faq__answer">We will not bill you until your product(s), including backordered or preordered items, are actualy shipped. If your items are ahipped separately you will be billed each time an item is shipped.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">How will the charge show up my credit card?</h5>
                                            <p class="faq__answer">The charge will appear on your credit card as: 'DRI*Western Digital Online Store'.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">How will you know where and how to send my physical product?</h5>
                                            <p class="faq__answer">If you order a physical product, a Shipping infomation page will appear during checkout so you can enter a shipping address and choose a shipping method.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">Can I order without a credit card?</h5>
                                            <p class="faq__answer">No. The only from of payment accepted is with a credit card.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="shipping">
                                <div class="row">
                                    <div class="col-12 col-lg-6 faq__colLeft">
                                        <div class="faq__item">
                                            <h5 class="faq__question">What is my order status?</h5>
                                            <p class="faq__answer">You can view your order status by looking up your order.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">What payments do you accept?</h5>
                                            <p class="faq__answer">We accept Visa, MasterCard, Discover, American Express and check cards or ATM cards, as long as they are connected with one of the major credit card companies listed above. You can safely enter your entire credit card number via our secure server, which encrypts all submitted information.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">What is PayPal Credit?</h5>
                                            <p class="faq__answer">Checkout fast with PayPal Credit. The effortless way to pay without using your credit card. Simply select PayPal Credit at checkout, answer two simple questions and accept the terms. It's that easy. There is no separate application process. PayPal Credit offers flexible terms that allow you to choose to pay in full or over time. Subject to credit approval. <span class='text-success'>See Terms.</span></p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">How do I enter a shipping address?</h5>
                                            <p class="faq__answer">A shipping infomation page will be presented where you can enter a separate shipping address and the shipping method can be chosen.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">Should I put spaces or dashes in the credit card number?</h5>
                                            <p class="faq__answer">Your card number should be entered in as a continuous strng of numbers.</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 faq__colRight">
                                        <div class="faq__item">
                                            <h5 class="faq__question">Why are you not accepting my credit card?</h5>
                                            <p class="faq__answer">There are many reasons for a failed credit card transaction. Your card may have expired or reached its limit or a credit card computer, either on our end or your bank's end, may have encountered a machine error.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">When will my credit card charged?</h5>
                                            <p class="faq__answer">We will not bill you until your product(s), including backordered or preordered items, are actualy shipped. If your items are ahipped separately you will be billed each time an item is shipped.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">How will the charge show up my credit card?</h5>
                                            <p class="faq__answer">The charge will appear on your credit card as: 'DRI*Western Digital Online Store'.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">How will you know where and how to send my physical product?</h5>
                                            <p class="faq__answer">If you order a physical product, a Shipping infomation page will appear during checkout so you can enter a shipping address and choose a shipping method.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">Can I order without a credit card?</h5>
                                            <p class="faq__answer">No. The only from of payment accepted is with a credit card.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="cancellation">
                                <div class="row">
                                    <div class="col-12 col-lg-6 faq__colLeft">
                                        <div class="faq__item">
                                            <h5 class="faq__question">What is my order status?</h5>
                                            <p class="faq__answer">You can view your order status by looking up your order.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">What payments do you accept?</h5>
                                            <p class="faq__answer">We accept Visa, MasterCard, Discover, American Express and check cards or ATM cards, as long as they are connected with one of the major credit card companies listed above. You can safely enter your entire credit card number via our secure server, which encrypts all submitted information.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">What is PayPal Credit?</h5>
                                            <p class="faq__answer">Checkout fast with PayPal Credit. The effortless way to pay without using your credit card. Simply select PayPal Credit at checkout, answer two simple questions and accept the terms. It's that easy. There is no separate application process. PayPal Credit offers flexible terms that allow you to choose to pay in full or over time. Subject to credit approval. <span class='text-success'>See Terms.</span></p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">How do I enter a shipping address?</h5>
                                            <p class="faq__answer">A shipping infomation page will be presented where you can enter a separate shipping address and the shipping method can be chosen.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">Should I put spaces or dashes in the credit card number?</h5>
                                            <p class="faq__answer">Your card number should be entered in as a continuous strng of numbers.</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 faq__colRight">
                                        <div class="faq__item">
                                            <h5 class="faq__question">Why are you not accepting my credit card?</h5>
                                            <p class="faq__answer">There are many reasons for a failed credit card transaction. Your card may have expired or reached its limit or a credit card computer, either on our end or your bank's end, may have encountered a machine error.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">When will my credit card charged?</h5>
                                            <p class="faq__answer">We will not bill you until your product(s), including backordered or preordered items, are actualy shipped. If your items are ahipped separately you will be billed each time an item is shipped.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">How will the charge show up my credit card?</h5>
                                            <p class="faq__answer">The charge will appear on your credit card as: 'DRI*Western Digital Online Store'.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">How will you know where and how to send my physical product?</h5>
                                            <p class="faq__answer">If you order a physical product, a Shipping infomation page will appear during checkout so you can enter a shipping address and choose a shipping method.</p>
                                        </div>
                                        <div class="faq__item">
                                            <h5 class="faq__question">Can I order without a credit card?</h5>
                                            <p class="faq__answer">No. The only from of payment accepted is with a credit card.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
