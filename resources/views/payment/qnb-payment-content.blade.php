<div class="reservation-header">
    <div class="container">
        <form action="{{ route('payment.confirm') }}" method="post">
            @csrf
            <div class="payment-terms-container">
                <div class="receipt-info">
                    <h3>تفاصيل الحجز</h3>
                    @php
                        $ticket = $tickets->first();
                    @endphp
                    <ul>
                        <input type="hidden" name="payment_key" value="{{ @$ticket->payment_key }}">
                        <li><strong>{{ __('Customer:') }}</strong> {{ @$ticket->user->name }} - {{ @$ticket->user->mobile }}</li>
                        <li><strong>{{ __('Receipt No.:') }}</strong> {{ @$ticket->payment_key }}</li>
                        <li><strong>{{ __('Number of Seats:') }}</strong> {{ @$tickets->count() }}</li>
                        <li><strong>{{ __('Total Amount: ') }}</strong> {{ @$tickets->sum('total') }} EGP</li>
                        <li><strong>{{ __('Trip time:') }}</strong>
                            {{ $tripTime }}
                        </li>
                    </ul>
                </div>

                <div class="terms-box">
                    <h4>
                        {!! $heroSection['title'] !!}
                    </h4>
                    <p>
                        {!! $heroSection['description'] !!}
                    </p>

                    <div class="agree-section">
                        <input type="checkbox" id="agree" name="agree" onchange="togglePaymentButton()">
                        <label for="agree">أوافق على الشروط والأحكام</label>
                    </div>

                    <button id="pay-now-btn" class="pay-btn" disabled onclick="proceedToPayment()">
                        Pay with Visa / Mastercard / Meeza
                    </button>
                    <div class="payment-methods">
                        <img src="{{ asset('images/pay/qnp.png') }}" class="payment-method" alt="QNB">
                        <img src="{{ asset('images/pay/visa.png') }}" class="payment-method" alt="Visa">
                        <img src="{{ asset('images/pay/master.png') }}" class="payment-method" alt="Mastercard">
                        <img src="{{ asset('images/pay/meeza.png') }}" class="payment-method" alt="Meeza">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>