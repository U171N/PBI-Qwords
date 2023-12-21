<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <title> Ecommerce</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/imgs/theme/favicon.svg') }}" />

    <!-- Di dalam tag <head> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" type="text/css"
        media="all" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/order_details.css') }}" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css?v=5.3') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .star.selected {
            color: gold;
            /* Change to your desired color */
        }

        .categories-dropdown-wrap {
            /* Add any necessary styling for the container */
        }

        .categori-dropdown-inner {
            display: flex;
        }

        .categories-list,
        .end {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            /* This ensures the items wrap to the next line when the container is not wide enough */
        }

        .categories-list li,
        .end li {
            padding: 8px;
        }

        /* Adjust the width and spacing of the items as needed */
    </style>

</head>

<body>
    <!-- Modal -->

    <!-- Header  -->

    @include('frontend.body.header')
    <!--End header-->



    <main class="main">
        @php
            use Illuminate\Support\Facades\Session;
        @endphp
        @yield('main')

    </main>

    @include('frontend.body.footer')



    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="{{ asset('frontend/assets/imgs/theme/loading.gif') }}" alt="" />
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor JS-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/slick.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.syotimer.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/waypoints.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/wow.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/magnific-popup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/counterup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/images-loaded.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/isotope.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/scrollup.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.vticker-min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.theia.sticky.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/plugins/jquery.elevatezoom.js') }}"></script>
    <!-- Template  JS -->
    <script src="{{ asset('frontend/assets/js/main.js?v=5.3') }}"></script>
    <script src="{{ asset('frontend/assets/js/shop.js?v=5.3') }}"></script>

    <script src="{{ asset('frontend/assets/js/script.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>

<!--Konfirmasi pesanan -->
<script>
    $(document).ready(function() {
        // Handle click event on "Konfirmasi Pesanan" link
        $(".update-status").click(function() {
            // Get the order ID from the data attribute
            var orderId = $(this).data("order-id");

            // Send an AJAX request to update the order status
            $.ajax({
                url: "/update-order-status", // Replace with the actual URL to update the status
                type: "POST", // Use POST or GET as appropriate
                data: { orderId: orderId, newStatus: 2 }, // Pass the order ID and new status
                success: function(response) {
                    // Update the status text in the table cell
                    $(this).closest("tr").find(".status-text").text("Sudah Diterima");

                    // Display a success message using SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Pesanan Diterima',
                    });
                },
                error: function() {
                    // Display an error message using SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terdapat Kesalahan.',
                    });
                }
            });
        });
    });
</script>


{{-- <script>
  $(document).ready(function() {
        $('.upload-button').click(function() {
            var orderId = $(this).data('orderid');
            var button = $(this);

            // Send an Ajax request to check if payment proof exists
            $.ajax({
                url: '/checkPaymentProof/' + orderId,
                type: 'GET',
                success: function(response) {
                    if (response.hasPaymentProof) {
                        button.prop('disabled', true);
                        alert('Payment proof has already been uploaded for this order.');
                    } else {
                        // Display the upload form
                        document.getElementById('uploadForm_' + orderId).style.display = 'block';
                    }
                },
                error: function() {
                    console.log('Error checking payment proof.');
                }
            });
        });
    });
</script> --}}



<!--fitur Review produk -->
<script type="text/javascript">
    $(document).ready(function() {
        $('.star').click(function() {
            const selectedValue = parseInt($(this).attr('data-value'));
            const productId = $(this).closest('.star-rating').attr('data-product-id');
            const comment = $('#comment').val(); // Get the comment value from the textarea

            // Update color and hidden input value
            $(this).addClass('selected');
            $(this).prevAll('.star').addClass('selected');
            $(this).nextAll('.star').removeClass('selected');
            $('input[name="rating"]').val(selectedValue);

            // Submit rating using AJAX
            submitRating(productId, selectedValue, comment);
        });

         // Function to disable the review button
         function disableReviewButton(productId) {
            $('.review-btn[data-product-id="' + productId + '"]').attr('disabled', true).addClass('disabled');
        }

        // Function to submit rating with AJAX
        function submitRating(productId, rating, comment) {
            $.ajax({
                type: "POST",
                url: '{{ route('submit.review') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId,
                    rating: rating,
                    comment: comment, // Include the comment value here
                },
                // Success response
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Review Success',
                        text: 'Testimoni Produk berhasil ditambahkan',
                    });
                },
                // Error response
                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ada Kesalahan Data'
                    });
                }
            });
        }
    });
</script>


    <!--Fitur WISHLIST-->

    <!--menambahkan data kedalam wishlit -->
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        //endpoint menambahkan product kedalam wishlist
        function addToWishList(product_id) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "/add-to-wishlist/" + product_id,
                success: function(data) {
                    wishlist();
                    // Start Message

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',

                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {

                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success,
                        })

                    } else {

                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error,
                        })
                    }

                    // End Message


                }
            })
        }
    </script>


    <!--Get data product wishlist-->
    <script type="text/javascript">
        function wishlist() {
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/get-wishlist-product/",

                success: function(response) {

                    $('#wishQty').text(response.wishQty);

                    var rows = ""
                    $.each(response.wishlist, function(key, value) {

                        rows += `<tr class="pt-30">
                        <td class="custome-checkbox pl-30">

                        </td>
                        <td class="image product-thumbnail pt-40">    <img src="/upload/product/${value.product.image1}" alt="#" />
</td>
                        <td class="product-des product-name">
                            <h6><a class="product-name mb-10" >${value.product.name} </a></h6>
                        </td>
                        <td class="price" data-title="Price">
                        ${value.product.discount_price == null
                        ? `<h3 class="text-brand">Rp${value.product.price}</h3>`
                        :`<h3 class="text-brand">Rp${value.product.discount_price}</h3>`

                        }

                        </td>
                        <td class="text-center detail-info" data-title="Stock">
                            ${value.product.amount > 0
                                ? `<span class="stock-status in-stock mb-0"> In Stock </span>`

                                :`<span class="stock-status out-stock mb-0">Stock Out </span>`

                            }

                        </td>

                        <td class="action text-center" data-title="Remove">
                            <a type="submit" class="text-body" id="${value.id}" onclick="wishlistRemove(this.id)" ><i class="fi-rs-trash"></i></a>
                        </td>
                    </tr> `

                    });

                    $('#wishlist').html(rows);

                }
            })
        }

        wishlist();

        //Remove data Wishlist

        function wishlistRemove(id) {
            $.ajax({
                type: "GET",
                dataType: "JSON",
                url: "/wishlist-remove/" + id,

                success: function(data) {
                    wishlist();

                    //membuat pesan
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',

                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success,
                        })
                    } else {
                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error,
                        })
                    }
                }
            })
        }
    </script>

    <!--Fitur Cart Product -->

    <script type="text/javascript">
        //menambahkan data kedalam cart belanja
        function addToCart() {
            var product_name = $('#product_name').text();
            var id = $('#product_id').val();
            var color = $('#color option:selected').text();
            var size = $('#size option:selected').text();
            var quantity = $('#qty').val();


            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    color: color,
                    size: size,
                    quantity: quantity,
                    product_name: product_name
                },
                url: "/cart/data/store/" + id,
                success: function(data) {
                    miniCart();
                    $('#closeModal').click();

                    //membuat pesan otomatis
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            title: data.success
                        })
                    } else {
                        Toast.fire({
                            type: 'error',
                            title: data.error,
                        })
                    }
                }
            })
        }

        //function CART detail
        function addToCartDetails() {
            var product_name = $('#dpname').text();
            var id = $('#dproduct_id').val();
            var color = $('#dcolor option:selected').text(); // Fetch selected color
            var size = $('#dsize option:selected').text(); // Fetch selected size
            var quantity = $('#dqty').val();
            var weight = $('#dproduct_weight').val(); // Fetch entered quantity
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    product_color: color, // Send correct attribute name
                    product_size: size, // Send correct attribute name
                    quantity: quantity,
                    name: product_name,
                    product_weight: weight
                },
                url: "/dcart/data/store/" + id,
                success: function(data) {
                    miniCart();

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            icon: 'success',
                            title: data.success,
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.error,
                        });
                    }
                }
            });
        }
    </script>

    <!--fitur mini Cart -->

    <script type="text/javascript">
        function miniCart() {
            $.ajax({
                type: 'GET',
                url: '/product/mini/cart',
                dataType: 'json',
                success: function(response) {
                    // console.log(response)

                    $('span[id="cartSubTotal"]').text(response.cartTotal);
                    $('#cartQty').text(response.cartQty);

                    var miniCart = ""

                    $.each(response.carts, function(key, value) {
                        miniCart += ` <ul>
        <li>
            <div class="shopping-cart-img">
                <img src="/upload/product/${value.options.image1}" alt="#" style="width:50px;height:50px;"">
            </div>
            <div class="shopping-cart-title" style="margin: -73px 74px 14px; width" 146px;>
                <h4> ${value.name}</h4>
                <h4><span>${value.qty} × </span>${value.price}</h4>
            </div>
            <div class="shopping-cart-delete" style="margin: -85px 1px 0px;">
                <a type="submit" id="${value.rowId}" onclick="miniCartRemove(this.id)"  ><i class="fi-rs-cross-small"></i></a>
            </div>
        </li>
    </ul>
    <hr><br>
           `
                    });

                    $('#miniCart').html(miniCart);

                }

            })
        }
        miniCart();


        /// Mini Cart Remove Start
        function miniCartRemove(rowId) {
            $.ajax({
                type: 'GET',
                url: '/minicart/product/remove/' + rowId,
                dataType: 'json',
                success: function(data) {
                    miniCart();
                    // Start Message

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {

                        Toast.fire({
                            type: 'success',
                            title: data.success,
                        })

                    } else {

                        Toast.fire({
                            type: 'error',
                            title: data.error,
                        })
                    }

                    // End Message

                }



            })
        }



        /// Mini Cart Remove End
    </script>

    <script type="text/javascript">
        //endpoint load data pada Keranjang Belanja

        function cart() {
            $.ajax({
                type: 'GET',
                url: '/get-cart-product',
                dataType: 'json',
                success: function(response) {
                    // console.log(response)


                    var rows = ""

                    $.each(response.carts, function(key, value) {
                        rows += `<tr class="pt-30">
            <td class="custome-checkbox pl-30">

            </td>
            <td class="image product-thumbnail pt-40">
                <img src="/upload/product/${value.options.image1}" alt="#">
</td>
            <td class="product-des product-name">
                <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">${value.name} </a></h6>

            </td>
            <td class="price" data-title="Price">
                <h4 class="text-body">@verbatim
     ${value.price.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}
@endverbatim</h4>

            </td>

              <td class="price" data-title="Price">
              ${value.options.color == null
                ? `<span>.... </span>`
                : `<h6 class="text-body">${value.options.color} </h6>`
              }
            </td>

               <td class="price" data-title="Price">
              ${value.options.size == null
                ? `<span>.... </span>`
                : `<h6 class="text-body">${value.options.size} </h6>`
              }
            </td>

            <td class="product-des product-name">
                <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html" >${value.weight}</h6>

            </td>
            <td class="text-center detail-info" data-title="Stock">
                <div class="detail-extralink mr-15">
                    <div class="detail-qty border radius">

     <a type="submit" class="qty-down" id="${value.rowId}" onclick="cartDecrement(this.id)"><i class="fi-rs-angle-small-down"></i></a>

      <input type="text" name="quantity" class="qty-val" value="${value.qty}" min="1">

     <a  type="submit" class="qty-up" id="${value.rowId}" onclick="cartIncrement(this.id)"><i class="fi-rs-angle-small-up"></i></a>

                    </div>
                </div>
            </td>
            <td class="price" data-title="Price">
                <h4 class="text-body">@verbatim
     ${value.subtotal.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}
@endverbatim</h4>
            </td>
            <td class="action text-center" data-title="Remove">
            <a type="submit" class="text-body"  id="${value.rowId}" onclick="cartRemove(this.id)"><i class="fi-rs-trash"></i></a></td>
        </tr>`
                    });

                    $('#cartPage').html(rows);

                }

            })
        }
        cart();


        //endpoint remove daftar keranjang belanja
        function cartRemove(id) {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/cart-remove/" + id,

                success: function(data) {
                    cart();
                    miniCart();
                    couponCalculation();

                    //membuat pesan otomatis
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success,
                        })
                    } else {
                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error
                        })
                    }
                }
            })
        }

        //melakukan penambahan data produk pada keranjang belanja otomatis/increment
        function cartIncrement(rowId) {
            $.ajax({
                type: 'GET',
                url: "/cart-increment/" + rowId,
                dataType: 'json',
                success: function(data) {
                    updateCartView(data.updatedCartItems);
                    couponCalculation();
                    cart();
                    miniCart();
                }
            })
        }

        function updateCartView(updatedCartItems) {
            // Loop through the updated cart items and update the quantity and weight in the view
            $.each(updatedCartItems, function(rowId, item) {
                const $row = $("#" + rowId).closest("tr"); // Find the row for this item
                $row.find(".qty-val").val(item.qty); // Update quantity input field
                $row.find(".product-weight").text(item.weight); // Update weight display
            });
        }

        //melakukan pengurangan data produk pada keranjang belanja otomatis/decrement

        function cartDecrement(rowId) {
            $.ajax({
                type: 'GET',
                url: "/cart-decrement/" + rowId,
                dataType: 'json',
                success: function(data) {
                    couponCalculation();
                    cart();
                    miniCart();
                }
            });
        }
    </script>

    <!--Fitur Kupon -->

    <script type="text/javascript">
        function applyCoupon() {
            var code = $('#code').val();
            $.ajax({
                type: "POST",
                dataType: 'json',
                data: {
                    code: code
                },
                url: "/coupon-apply",
                success: function(data) {
                    couponCalculation();


                    if (data.validity === true) {
                        $('#couponField').hide();
                    }

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    if (data.validity) {
                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success,
                        });
                    } else {
                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error,
                        });
                    }
                }
            });
        }


        // Start CouponCalculation Method
        function couponCalculation() {
            $.ajax({
                type: 'GET',
                url: "/coupon-calculation",
                dataType: 'json',
                success: function(data) {
                    if (data.code) {
                        $('#couponCalField').html(
                            `<tr>
                        <td class="cart_total_label">
                            <h6 class="text-muted">Subtotal</h6>
                        </td>
                        <td class="cart_total_amount">
                            <h4 class="text-brand text-end">@verbatim
                                Rp ${data.subtotal.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}
                            @endverbatim</h4>
                        </td>
                    </tr>

                    <tr>
                        <td class="cart_total_label">
                            <h6 class="text-muted">Coupon </h6>
                        </td>
                        <td class="cart_total_amount">
                            <h6 class="text-brand text-end">${data.code} <a type="button" onclick="couponRemove()"><i class="fi-rs-trash"></i></a></h6>
                        </td>
                    </tr>

                    <tr>
                        <td class="cart_total_label">
                            <h6 class="text-muted">Discount Amount  </h6>
                        </td>
                        <td class="cart_total_amount">
                            <h4 class="text-brand text-end">$${data.discount_amount}</h4>
                        </td>
                    </tr>

                    <tr>
                        <td class="cart_total_label">
                            <h6 class="text-muted">Grand Total </h6>
                        </td>
                        <td class="cart_total_amount">
                            <h4 class="text-brand text-end">$${data.total_amount}</h4>
                        </td>
                    </tr>`
                        );
                    } else {
                        $('#couponCalField').html(
                            `<tr>
                        <td class="cart_total_label">
                            <h6 class="text-muted">Subtotal</h6>
                        </td>
                        <td class="cart_total_amount">
                            <h4 class="text-brand text-end">@verbatim
                                Rp ${data.subtotal.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}
                            @endverbatim</h4>
                        </td>
                    </tr>

                    <tr>
                        <td class="cart_total_label">
                            <h6 class="text-muted">Total Keseluruhan</h6>
                        </td>
                        <td class="cart_total_amount">
                            <h4 class="text-brand text-end">@verbatim
                                Rp ${data.total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' })}
                            @endverbatim</h4>
                        </td>
                    </tr>`
                        );
                    }
                }
            });
        }

        // Call couponCalculation function to update the coupon calculation on page load
        couponCalculation();

        // Start CouponCalculation Method
    </script>


    <!--fitur hapus kupon -->
    <script type="text/javascript">
        function couponRemove() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/coupon-remove",

                success: function(data) {
                    couponCalculation();
                    $("#couponField").show();

                    //membuat pesan otomatis
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: data.success,
                        })
                    } else {
                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error,
                        })
                    }
                }
            })
        }
    </script>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>

</html>
