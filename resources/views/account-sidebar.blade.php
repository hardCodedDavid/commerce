<div class="col-lg-4 mb-4">
    <div class="ps-section__left">
        <aside class="ps-widget--account-dashboard">
            <div class="ps-widget__content">
                <ul>
                    <li @if($active == 'account') class="active" @endif><a href="/account"><i class="icon-user"></i> My Account</a></li>
                    <li @if($active == 'orders') class="active" @endif><a href="/orders"><i class="icon-papers"></i> Orders</a></li>
                    <li><a href="/cart"><i class="icon-cart"></i> Cart</a></li>
                    <li><a href="/wishlist"><i class="icon-heart"></i> Wishlist</a></li>
                    <li><a href="javaScript:void(0);" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon-power-switch"></i>Logout</a></li>
                </ul>
            </div>
        </aside>
    </div>
</div>