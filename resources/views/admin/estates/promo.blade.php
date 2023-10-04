@extends('layouts.app')
@section('content')
    <div class=" d-flex row-cols-3 justify-content-center">
        <div class="card col me-2">
            <img src="http://[::1]:5173/public/Silver.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Silver</h5>
                <p class="card-text">Metti in evidenza il tuo annuncio per 24 ore!</p>
                <a href="#" class="btn btn-primary">€2,99</a>
            </div>
        </div>
        <div class="card col me-2">
            <img src="http://[::1]:5173/public/Gold.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Gold</h5>
                <p class="card-text">Metti in evidenza il tuo annuncio per 72 ore!</p>
                <a href="#" class="btn btn-primary">€5,99</a>
            </div>
        </div>
        <div class="card col">
            <img src="http://[::1]:5173/public/Platinum.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Platinum</h5>
                <p class="card-text">Metti in evidenza il tuo annuncio per 144 ore!</p>
                <a href="#" class="btn btn-primary">€9,99</a>
            </div>
        </div>
    </div>
@endsection
