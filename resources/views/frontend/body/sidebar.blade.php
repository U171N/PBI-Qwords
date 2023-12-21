
@php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

// $route = Route::current()->getName();
@endphp

<div class="col-md-3">
    @auth
                                <span class="lable ml-0">Account</span>
                                <div class="dashboard-menu">
                                    <ul class="nav flex-column" role="tablist">
                                        <li class="nav-item">

                                            <a href="{{ route('update.profile.customer') }}"><i
                                                    class="fi fi-rs-user mr-10"></i>My
                                                Account</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('order.customer') }}"><i
                                                    class="fi fi-rs-location-alt mr-10"></i>Cek Pesanan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('detailOrder.customer') }}"><i class="fi fi-rs-label mr-10"></i>Riwayat Pesanan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('wishlist') }}"><i class="fi fi-rs-heart mr-10"></i>My
                                                Wishlist</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('customer.ubah.password') }}"><i
                                                    class="fi fi-rs-settings-sliders mr-10"></i>Ubah Password</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('user.logout') }}"><i
                                                    class="fi fi-rs-sign-out mr-10"></i>Sign out</a>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route('login') }}"><span class="lable ml-0">Login</span></a>

                                <span class="lable" style="margin-left: 2px; margin-right: 2px;"> | </span>


                                <a href="{{ route('register') }}"><span class="lable ml-0">Register</span></a>

                            @endauth
{{-- <div class="dashboard-menu">
<ul class="nav flex-column" role="tablist">
    <li class="nav-item">
        <a class="nav-link {{ ($route ==  'dashboard')? 'active':  '' }} "  href="{{ route('dashboard') }}" ><i class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " href="" ><i class="fi-rs-shopping-bag mr-10"></i>Orders</a>
    </li>

     <li class="nav-item">
        <a class="nav-link" href="" ><i class="fi-rs-shopping-bag mr-10"></i>Return Orders</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('order.customer') }}" ><i class="fi-rs-shopping-cart-check mr-10"></i>Track Your Order</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ ($route ==  'update.profile.customer')? 'active':  '' }}" href="{{ route('update.profile.customer') }}" ><i class="fi-rs-user mr-10"></i>Account details</a>
    </li>

      <li class="nav-item">
        <a class="nav-link {{ ($route ==  'customer.ubah.password')? 'active':  '' }}" href="{{ route('customer.ubah.password') }}" ><i class="fi-rs-user mr-10"></i>Change Password</a>
    </li>


    <li class="nav-item" style="background:#ddd;">
        <a class="nav-link" href="{{ route('user.logout') }}"><i class="fi-rs-sign-out mr-10"></i>Logout</a>
    </li>
</ul>
</div> --}}
</div>