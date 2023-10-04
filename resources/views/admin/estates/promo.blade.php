@extends('layouts.app')
@section('content')
    <div class="container h-50 mt-4">
        <div class="d-flex row-cols-3 row-cols-md-4 row-cols-xl-5 justify-content-center">
            <div class="card col">
                <img src="http://[::1]:5173/public/Silver.png" class="card-img-top" alt="Silver sponsorship">
                <div class="card-body">
                    <h5 class="card-title">Silver</h5>
                    <p class="card-text">Metti in evidenza il tuo annuncio per 24 ore!</p>
                    <a href="{{ route('admin.estates.payments') }}" class="btn btn-dark">
                        <span>€ 2,99</span>
                    </a>
                </div>
            </div>
            <div class="card col mx-3">
                <img src="http://[::1]:5173/public/Gold.png" class="card-img-top" alt="Gold sponsorship">
                <div class="card-body">
                    <h5 class="card-title">Gold</h5>
                    <p class="card-text">Metti in evidenza il tuo annuncio per 72 ore!</p>
                    <a href="{{ route('admin.estates.payments') }}" class="btn btn-dark">€ 5,99</a>
                </div>
            </div>
            <div class="card col">
                <img src="http://[::1]:5173/public/Platinum.png" class="card-img-top" alt="Platinum sponsorship">
                <div class="card-body">
                    <h5 class="card-title">Platinum</h5>
                    <p class="card-text">Metti in evidenza il tuo annuncio per 144 ore!</p>
                    <a href="{{ route('admin.estates.payments') }}" class="btn btn-dark">€ 9,99</a>
                </div>
            </div>
        </div>
    </div>
@endsection
