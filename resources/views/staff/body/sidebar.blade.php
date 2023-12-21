<!--sidebar wrapper -->
@php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
@endphp
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('frontend/assets/imgs/icon/icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Staff</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('staff.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Category</div>
            </a>
            <ul>
                <li> <a href="{{ route('all.category') }}"><i class="bx bx-right-arrow-alt"></i>Daftar Category</a>
                </li>
                <li> <a href="{{ route('tambah.category') }}"><i class="bx bx-right-arrow-alt"></i>Tambah Category</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-category"></i>
                </div>
                <div class="menu-title">Produk</div>
            </a>
            <ul>
                <li> <a href="{{ route('all.produk') }}"><i class="bx bx-right-arrow-alt"></i>Daftar Produk</a>
                </li>
                <li> <a href="{{ route('tambah.produk') }}"><i class="bx bx-right-arrow-alt"></i>Tambah Produk</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="lni lni-invention"></i>
                </div>
                <div class="menu-title">Kelola Kupon</div>
            </a>
            <ul>
                <li> <a href="{{ route('all.coupon') }}"><i class="bx bx-right-arrow-alt"></i>Daftar Kupon</a>
                </li>

                <li> <a href="{{ route('add.coupon') }}"><i class="bx bx-right-arrow-alt"></i>Tambah Kupon</a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-cart'></i>
                </div>
                <div class="menu-title">Kelola Order</div>
            </a>
            <ul>
                <li> <a href="{{ route('pending.staff') }}"><i class="bx bx-right-arrow-alt"></i>Order Di proses</a>
                </li>
                <li> <a href="{{ route('dikirim.staff') }}"><i class="bx bx-right-arrow-alt"></i>Order Di Kirim</a>
                </li>
                <li> <a href="{{ route('selesai.staff') }}"><i class="bx bx-right-arrow-alt"></i>Order Selesai</a>
                </li>
                <li> <a href="{{ route('batal.staff') }}"><i class="bx bx-right-arrow-alt"></i>Order Batal</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('penjualan.all') }}">
                <div class="parent-icon"><i class="lni lni-stats-up"></i>
                </div>
                <div class="menu-title">Laporan Penjualan</div>
            </a>
        </li>
        <li>
            <a href="{{ route('review.all') }}">
                <div class="parent-icon"><i class="lni lni-indent-increase"></i>
                </div>
                <div class="menu-title">Review Manage</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->
