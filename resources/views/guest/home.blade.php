@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="d-flex align-items-center justify-content-center flex-column">
        <h1 class="my-4">Benvenuti su Boolbnb!</h1>
        <div id="home-logo">
            <img src="{{ url('display-logo') }}" alt="BoolBnB">
        </div>
    </div>
@endsection
