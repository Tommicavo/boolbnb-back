@extends('layouts.app')
@section('title', 'Offerte')
@section('content')

    <div class="mt-4 mb-2">
        <span><strong>Annuncio</strong></span>
        <span>: {{ $estate->title }} </span>
    </div>
    <div>
        <span><strong>Autore</strong></span>
        <span>: {{ $estate->user->name ? $estate->user->name : 'anonimo' }} </span>
    </div>
    <div class="container h-50 mt-4">
        <div class=" d-flex row-cols-3 justify-content-center">
            @foreach ($sponsorships as $sponsorship)
                <div class="card col me-2">
                    <div class="card-body">
                        <h5 class="card-title">{{ $sponsorship->name }}</h5>
                        <h6>Sponsor di {{ $sponsorship->level }}° livello</h6>
                        <p class="card-text py-2">Metti in evidenza il tuo annuncio per {{ $sponsorship->duration }} ore!</p>
                        <form method="POST"
                            action="{{ route('admin.payments.validateCreditCard', ['estate' => $estate->id, 'sponsorship' => $sponsorship->id]) }}">
                            @csrf
                            <button class="bt bt-dark-g" type="submit">{{ $sponsorship->price }}€</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

{{-- 
<form method="POST"
action="{{ route('admin.estates.payments', ['estate' => $estate->id, 'sponsorship' => $sponsorship->id]) }}">
@csrf
<button type="submit" class="btn btn-primary">Acquista</button>
</form> --}}
