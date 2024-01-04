@extends('layout.app')
@section('title') Stripe Payment @endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-2 mb-2">
                <h3 class="text-center">Laravel 9 Stripe Payment Gateway Integration Example Tutorial</h3><hr>
            </div>
            <div class="col-md-12 mt-2 mb-2">
                <pre id="res_token"></pre>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <button class="btn btn-primary btn-block" onclick="stripePay(10)">Pay $10</button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-success btn-block" onclick="stripePay(50)">Pay $50</button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-info btn-block" onclick="stripePay(100)">Pay $100</button>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src = "https://checkout.stripe.com/checkout.js" > </script>

    <script type = "text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        function stripePay(amount) {
            var handler = StripeCheckout.configure({
                key: 'pk_test_51O9L6YSBSgntllDPMe4HWvaF1Ue5lqKm0haLA2Nwc6XN0y67bjPqk6U1xVm87BWoID2ZelQ8lTfspLmT57ZU4T6f00LKucFcrF', // your publisher key id
                locale: 'auto',
                token: function(token) {
                    // You can access the token ID with `token.id`.
                    // Get the token ID to your server-side code for use.
                    console.log('Token Created!!');
                    console.log(token);
                    $('#res_token').html(JSON.stringify(token));
                    $.ajax({
                        url: '{{ url("payment-process") }}',
                        method: 'post',
                        data: {
                            tokenId: token.id,
                            amount: amount
                        },
                        success: (response) => {
                            console.log(response)
                        },
                        error: (error) => {
                            console.log(error);
                            alert('Oops! Something went wrong')
                        }
                    })
                }
            });
            handler.open({
                name: 'Demo Site',
                description: '2 widgets',
                amount: amount * 100
            });
        }
    </script>
@endpush
