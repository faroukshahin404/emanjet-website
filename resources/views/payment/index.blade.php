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
            /* عشان يظهر السكرول بشكل لطيف */
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
            height: 50px;
            border-radius: 10px;

        }
    </style>
@endpush

@section('content')
    @include('payment.qnb-payment-content')
@endsection
@section('mobile-content')
    @include('payment.qnb-payment-content')
@endsection
@push('scripts')
    <script>
        function togglePaymentButton() {
            const checkbox = document.getElementById('agree');
            const button = document.getElementById('pay-now-btn');
            button.disabled = !checkbox.checked;
        }

        function proceedToPayment() {
            // Replace this with your actual redirect or payment logic
            window.location.href = "{{ $payment_url ?? '#' }}";
        }
    </script>
@endpush
