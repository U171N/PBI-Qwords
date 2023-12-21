@extends('frontend.master_dashboard')
@section('main')
@section('title')
    Checkout Page
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    
@endphp

<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ url('/') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Checkout
        </div>
    </div>
</div>
<div class="container mb-80 mt-50">
    <div class="row">
        <div class="col-lg-8 mb-40">
            <h3 class="heading-2 mb-10">Checkout</h3>
            <div class="d-flex justify-content-between">
                <h6 class="text-body">Daftar Produk dari Keranjang Belanja Anda</h6>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7">

            <div class="row">
                <h4 class="mb-30">Billing Details</h4>
                <form method="post" action="{{ route('checkout.store') }}">
                    @csrf

                    <div class="row">
                        <div class="form-group col-lg-6">
                            <input type="text" required="" name="shipping_name" value="{{ Auth::user()->name }}">
                        </div>
                        <div class="form-group col-lg-6">
                            <input type="email" required="" name="shipping_email"
                                value="{{ Auth::user()->email }}">
                        </div>
                    </div>



                    <div class="row shipping_calculator">
                        <div class="form-group col-lg-6">
                            <div class="custom_select">
                                <select name="division_id" class="form-control">
                                    <option value="">Select Division...</option>
                                    @foreach ($divisions as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <input required="" type="text" name="shipping_phone"
                                value="{{ Auth::user()->phone }}">
                        </div>
                    </div>

                    <div class="row shipping_calculator">
                        <div class="form-group col-lg-6">
                            <div class="custom_select">
                                <select name="district_id" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">

                            <input required="" type="text" name="post_code" placeholder="Post Code *">
                        </div>
                    </div>


                    <div class="row shipping_calculator">

                        <div class="form-group col-lg-6">
                            <div class="custom_select">
                                <select name="product_id" class="form-control" id="product-select">
                                    <option value="">Select Product...</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->product_id }}" data-weight="{{ $product->product_weight }}">
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Hidden input field to store the selected product's weight -->
                            <input type="hidden" name="selected_weight" id="selected-weight" value="{{ $product->product_weight }}">
                            
                            
                        </div>

                        <div class="form-group col-lg-6">
                            <div class="custom_select">
                                {{-- <select name="courier" class="form-control" id="courier-select">
                                    <option value="jne">JNE</option>
                                    <option value="tiki">TIKI</option>
                                    <option value="pos">POS INDONESIA</option>
                                </select> --}}
                                <select name="paket" class="form-control" id="paket-select">
                                    <option value="regular">Regular</option>
                                    <option value="express">Ekspress</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-lg-6">
                            <input required="" type="text" name="shipping_address" placeholder="Address *"
                                value="{{ Auth::user()->address }}">
                        </div>


                        <div class="form-group col-lg-6">
                            <div class="custom_select">
                                <select name="courier" class="form-control" id="courier-select">
                                    <option value="jne">JNE</option>
                                    <option value="tiki">TIKI</option>
                                    <option value="pos">POS INDONESIA</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-30">
                        <textarea rows="5" placeholder="Additional information" name="notes"></textarea>
                        <label for="">Biaya Ongkos Kirim</label>
                        <h4  name="ongkir" id="shipping-cost">Rp </h4>
                        <input type="hidden" name="hidden_shipping_cost" id="hidden-shipping-cost" value="">

                    </div>




            </div>
        </div>


        <div class="col-lg-5">
            <div class="border p-40 cart-totals ml-30 mb-50">
                <div class="d-flex align-items-end justify-content-between mb-30">
                    <h4>Your Order</h4>

                </div>
                <div class="divider-2 mb-30"></div>
                <div class="table-responsive order_table checkout">
                    <table class="table no-border">
                        <tbody>
                            @foreach ($carts as $item)
                                <tr>
                                    <td class="image product-thumbnail"><img
                                            src="{{ asset('upload/product/' . $item->options->image1) }} "
                                            alt="#" style="width:50px; height: 50px;">
                                        <h6 class="w-160 mb-5">{{ $item->name }}</h6>
                                    </td>
                                    <td>
                                        <div class="product-rate-cover">

                                            <strong>Color :{{ $item->options->color }} </strong>
                                            <br>
                                            <strong>Size : {{ $item->options->size }}</strong>
                                            <br>
                                            @php
                                            $products = App\Models\Products::latest()->get();
                                        @endphp
                                        @foreach ($products as $product)
                                        <strong>Berat (Gram): {{ $product->product_weight }}</strong>
                                        @endforeach
        
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="text-muted pl-20 pr-20">x {{ $item->qty }}</h6>
                                    </td>
                                    <td>
                                        <h4 class="text-brand">Rp {{ $item->price }}</h4>
                                    </td>

                                   <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Biaya TAX </h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <p class="text-brand text-end">  Rp {{ $item->tax }}</p>
                                        <input type="hidden" name="tax" id="biaya_tax" value=" {{ $item->tax }}">
                                    </td>
                                   </tr>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>




                    <table class="table no-border">
                        <tbody>

                            @if (Session::has('coupon'))
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Subtotal</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end">Rp {{ $cartTotal }}</h4>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Coupon Name</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h6 class="text-brand text-end">{{ session()->get('coupon')['code'] }} (
                                            {{ session()->get('coupon')['discount'] }}% ) </h6>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Coupon Discount</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end">
                                            Rp {{ session()->get('coupon')['discount_amount'] }}</h4>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Total Keseluruhan</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end">Rp
                                            {{ session()->get('coupon')['total_amount'] }}
                                        </h4>
                                    </td>

                                </tr>
                            @else
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Total Keseluruhan </h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end">Rp {{ $cartTotal }}</h4>
                                        <input type="hidden" name="total_biaya" id="total_biaya" value="{{ $cartTotal }}">

                                    </td>
                                </tr>
                            @endif



                        </tbody>
                    </table>





                </div>
            </div>
            <div class="payment ml-30">
                <button type="submit" class="btn btn-fill-out btn-block mt-30">Place an Order<i
                        class="fi-rs-sign-out ml-15"></i></button>
            </div>
        </div>
    </div>
</div>


</form>



<script type="text/javascript">

$(document).ready(function() {
    $('#product-select').on('change', function() {
        
        // Get the selected product's weight from the data-weight attribute
        let selectedWeight = $(this).find(':selected').data('weight');
        
        // Update the hidden input field with the selected weight
        $('#selected-weight').val(selectedWeight);
        
        // Calculate and update the shipping cost
        updateShippingCost();
    });
    
    $('#paket-select').on('change', function() {
        // Calculate and update the shipping cost
        updateShippingCost();
    });
});

function updateShippingCost() {
    let selectedWeight = parseFloat($('#selected-weight').val());
    let selectedPackage = $('#paket-select').val();

    // Call the backend API to calculate the shipping cost
    $.ajax({
        type: 'POST',
        url: '/calculate-shipping-cost', // Change this URL to your actual backend endpoint
        data: {
            weight: selectedWeight,
            paket: selectedPackage,
            // You might need to pass other data as needed
        },
        success: function(response) {
            if (response.success) {
                let formattedShippingCost =  response.shipping_cost.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
                $('#shipping-cost').text(formattedShippingCost);
                $('#hidden-shipping-cost').val(response.shipping_cost);
            } else {
                console.error(response.message);
            }
        },
        error: function(error) {
            console.error(error.responseText);
        }
    });
}

// Attach the function to input and change events
$('#selected-weight, #paket-select').on('input change', updateShippingCost);


    //check ongkir raja ongkir
//     $(document).ready(function() {
//     $('#courier-select').on('change', function() {
//         let origin = $('select[name="division_id"]').val();
//         let courier = $('#courier-select').val();
//         let destination = $('select[name="district_id"]').val();
//         let selectedWeight = $('#selected-weight').val(); // Fetch the stored weight

//         if (courier && selectedWeight && origin && destination) {
//             $.ajax({
//                 url: "{{ route('calculate.shipping.cost') }}",
//                 type: "POST",
//                 data: {
//                     _token: "{{ csrf_token() }}",
//                     origin: origin,
//                     destination: destination,
//                     courier: courier,
//                     weight: selectedWeight
//                 },
//                 dataType: 'json',
//                 success: function(data) {
//                     if (data.success) {
//                         var costs = data.data;
//                         var shippingCost = '';

//                         for (var i = 0; i < costs.length; i++) {
//                             if (costs[i].service.toLowerCase() === courier.toLowerCase()) {
//                                 shippingCost = costs[i].cost[0].value;
//                                 break;
//                             }
//                         }

//                         if (shippingCost !== '') {
//                             $("#shipping-cost").text('Rp ' + shippingCost);
//                         }
//                     } else {
//                         console.log('API Error:', data.message);
//                         $('#shipping-cost').text('Rp 0');
//                     }
//                 },
//             });
//         } else {
//             $('#shipping-cost').text('Rp 0');
//         }
//     });
// });




    $(document).ready(function() {
        $('select[name="division_id"]').on('change', function() {
            var division_id = $(this).val();
            if (division_id) {
                $.ajax({
                    url: "{{ url('/province/ajax') }}/" + division_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="state_id"]').html('');
                        var d = $('select[name="district_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="district_id"]').append(
                                '<option value="' + value.id + '">' + value
                                .name + '</option>');
                        });
                    },

                });
            } else {
                alert('danger');
            }
        });
    });


    // Show State Data

    $(document).ready(function() {
        $('select[name="district_id"]').on('change', function() {
            var district_id = $(this).val();
            if (district_id) {
                function district() {
                    $.ajax({
                        url: "{{ url('/city/ajax/') }}/" + district_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="state_id"]').html('');
                            var d = $('select[name="state_id"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="state_id"]').append(
                                    '<option value="' + value.id + '">' + value
                                    .state_name + '</option>');
                            });
                        },

                    });
                }
            } else {
                alert('danger');
            }
        });
    });
</script>



@endsection
