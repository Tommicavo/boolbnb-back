@extends('layouts.app')
@section('content')
    <div class="container w-50">
        <div id="dropin-container"></div>
        <button id="submit-button" class="btreebutton button--small button--green">Acquista</button>
    </div>
@endsection
@section('scripts')
    @vite(['resources/js/payment.js'])
@endsection
