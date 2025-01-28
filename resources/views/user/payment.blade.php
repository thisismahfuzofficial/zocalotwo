<!-- resources/views/payment.blade.php -->
<x-main>
    @php
        $shipping_info = json_decode($order->shipping_info, true) ?? [];
    @endphp
    <div class="container mb-4">
        <h2 class="my-4 fw-bold text-danger">Payment</h2>
        <form action="{{ route('user.orders.payment.complete', $order) }}" method="POST" id="payment">
            @csrf
            <input type="hidden" name="payment_id" id="payment_id">
            <!-- Order Summary -->
            <div class="row align-items-stretch">
                <div class="col-md-6">
                    <div class="card mb-4 rounded-0 shadow p-3 border-0 h-100">
                        <h3 class="fw-bold text-danger container">
                            Order Summary
                        </h3>
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>Order :</th>
                                    <td>#{{ $order->id ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Price :</th>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Shipping Address :</th>
                                    <td>{{ $shipping_info['address'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4 rounded-0 shadow p-3 border-0 h-100">
                        <h2 class="my-4 fw-bold text-danger">Card Info</h2>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control"
                                value="{{ $shipping_info['f_name'] . ' ' . $shipping_info['l_name'] }}"
                                id="floatingInput" placeholder="name" readonly>
                            <label for="floatingInput">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" value="{{ $shipping_info['email'] }}"
                                id="floatingInput" placeholder="name@example.com" readonly>
                            <label for="floatingInput">Email address</label>
                        </div>
            
                        <div class="border rounded px-3 mb-3">
                            <div id="card-element" class="mt-3 mb-3">
                                <!-- Elements will create input elements here -->
                            </div>
                            <!-- We'll put the error messages in this element -->
                            <div id="card-errors" role="alert"></div>
                        </div>
                        <div class="form-group text-end">
                            <button class="btn btn-danger" id="complete-order" type="submit">Pay Now</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Payment Method Selection -->
            {{-- <div class="card mb-4">
                <div class="card-header">
                    Payment Method
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Select Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-control border" required>
                            <option>Select Payment Method</option>
                            <option value="credit_card">Credit Card</option>
                            <option value="paypal">PayPal</option>
                            <option value="bank_transfer">Bank Transfer</option>
                        </select>
                    </div>
                </div>
            </div> --}}

            <!-- Payment Details (if applicable) -->
            {{-- <div class="card mb-4" id="credit-card-details" style="display: none;">
                <div class="card-header">
                    Credit Card Details
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="card_number" class="form-label">Card Number</label>
                        <input type="text" name="card_number" id="card_number" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="card_expiry" class="form-label">Expiry Date</label>
                        <input type="text" name="card_expiry" id="card_expiry" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="card_cvv" class="form-label">CVV</label>
                        <input type="text" name="card_cvv" id="card_cvv" class="form-control">
                    </div>
                </div>
            </div> --}}

            <!-- Submit Button -->
            {{-- <button type="submit" class="btn btn-primary">Pay Now</button> --}}
        </form>
    </div>



    {{-- @push('js') --}}
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function() {
            // Create a Stripe client.

            var stripe = Stripe(
                "pk_test_51Qk8N9P0HfV4CtGoHP6gWwI7FnmRLvGhI8tDKjo88tFerFGoNrq29a28mPi4AYL9Pva2WNMKzhb3UEETnxMei6HW00b70Wn2rE"
            );
            // Create an instance of Elements.
            var elements = stripe.elements();
            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
                base: {
                    color: '#32325d',
                    margin: '10px',
                    fontFamily: '"Montserrat", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }

                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };
            // Create an instance of the card Element.
            var card = elements.create('card', {
                style: style,
                hidePostalCode: true
            });
            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');
            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
            // Handle form submission.
            var form = document.getElementById('payment');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                // Disable the submit button to prevent repeated clicks
                document.getElementById('complete-order').disabled = true;
                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error.
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                        // Enable the submit button
                        document.getElementById('complete-order').disabled = false;
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);

                    }
                });
            });

            function stripeTokenHandler(token) {
                document.getElementById('payment_id').value = token.id
                console.log(token.id)
                form.submit();
            }
        })();
    </script>
    {{-- @endpush --}}

</x-main>
