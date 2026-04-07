@extends('layouts.master')
@push('styles')
    <style>
        .payment-terms-container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            font-family: "Cairo", sans-serif;
            direction: rtl;
        }

        .receipt-info ul {
            list-style: none;
            padding: 0;
            margin: 10px 0;
        }

        .receipt-info li {
            padding: 6px 0;
            border-bottom: 1px solid #eee;
        }


        .terms-box h4 {
            margin-top: 20px;
            font-size: 20px;
            color: #444;

        }

        .terms-box p {
            margin: 10px 0;
            color: #666;
            line-height: 1.8;
            max-height: 100px;
            overflow-y: auto;
            padding-right: 10px;
            /* Smoother scrollbar appearance in this panel */
        }

        .agree-section {
            display: flex;
            align-items: center;
            margin: 15px 0;
        }

        .agree-section input[type="checkbox"] {
            margin-left: 8px;
            transform: scale(1.3);
        }

        .pay-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            cursor: not-allowed;
            width: 100%;
            transition: 0.3s;
        }

        .pay-btn:enabled {
            cursor: pointer;
            background-color: #218838;
        }

        .payment-methods {
            display: flex;
            justify-content: center;
            margin-top: 10px;

        }

        .payment-method {
            /* width: 50px; */
            height: 30px;

        }
    </style>
@endpush

@section('content')
    <div class="reservation-header">
        <div class="container">
            <form action="{{ route('payment.confirm') }}" method="post">
                @csrf
                <div class="payment-terms-container">
                    <div class="receipt-info">
                        <h3>{{ __('Booking details') }}</h3>
                        @php
                            $ticket = $tickets->first();
                        @endphp
                        <ul>
                            <input type="hidden" name="payment_key" value="{{ @$ticket->payment_key }}">
                            <li><strong>{{ __('Customer:') }}</strong> {{ @$ticket->user->name }} -
                                {{ @$ticket->user->mobile }}</li>
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
                            <label for="agree">{{ __('I agree to the terms and conditions') }}</label>
                        </div>

                        <button id="pay-now-btn" class="pay-btn" disabled>
                            <small style="font-size: 12px;">
                                Pay with Visa / Mastercard / Meeza
                            </small>
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
@endsection
@section('mobile-content')
    <form action="{{ route('payment.confirm') }}" method="post">
        @csrf
        <div class="payment-terms-container">
            <div class="receipt-info">
                <h3>{{ __('Booking details') }}</h3>
                @php
                    $ticket = $tickets->first();
                @endphp
                <ul>
                    <input type="hidden" name="payment_key" value="{{ @$ticket->payment_key }}">
                    <li><strong>{{ __('Customer:') }}</strong> {{ @$ticket->user->name }} - {{ @$ticket->user->mobile }}
                    </li>
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
                    <input type="checkbox" id="agree-mobile" name="agree" onchange="togglePaymentButtonMobile()">
                    <label for="agree-mobile">{{ __('I agree to the terms and conditions') }}</label>
                </div>

                <button id="pay-now-btn-mobile" class="pay-btn" disabled>
                    <small style="font-size: 12px;">
                        Pay with Visa / Mastercard / Meeza
                    </small>
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
@endsection
@push('scripts')
    <script>
        function togglePaymentButton() {
            const checkbox = document.getElementById('agree');
            const button = document.getElementById('pay-now-btn');
            button.disabled = !checkbox.checked;
        }
        function togglePaymentButtonMobile() {
            const checkbox = document.getElementById('agree-mobile');
            const button = document.getElementById('pay-now-btn-mobile');
            button.disabled = !checkbox.checked;
        }

        
    </script>
@endpush
