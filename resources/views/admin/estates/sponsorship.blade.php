@extends('layouts.app')
@section('content')
    <div class="container payment-div">
        <div id="dropin-wrapper">
            <div id="dropin-container"></div>
        </div>
        <form method="POST" id="paymentBtn"
            action="{{ route('admin.payments.sponsorship', ['estate' => $estate->id, 'sponsorship' => $sponsorship->id]) }}">
            @csrf
            <button type="submit" class="btn btn-primary">Acquista</button>
        </form>
        <div class="spinnerContainer d-flex justify-content-center align-items-center">
            <div id="paymentSpinner" class="spinner-border text-primary d-none" role="status"></div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/payment.js'])
@endsection
