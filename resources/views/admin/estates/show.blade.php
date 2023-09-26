@extends('layouts.app')

@section('title', $estate->title)

@section('content')

    <div class="d-flex justify-content-between align-items-center my-3">
        <h1>Dettagli della casa</h1>
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.estates.index') }}" class="btn btn-outline-secondary me-5">Torna alla lista</a>
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.estates.edit', $estate) }}" class="btn btn-outline-warning">
                    <i class="fas fa-pencil"></i> Modifica
                </a>
                <form action="{{ route('admin.estates.destroy', $estate) }}" method="POST" class="delete-form ms-2">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger">
                        <i class="fas fa-trash"></i> Elimina
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        <img style="height: 26rem; object-fit: cover;" src="{{ $estate->cover }}" class="card-img-top"
            alt="{{ $estate->title }}">
        <div class="card-body">
            <h5 class="card-title">{{ $estate->title }}</h5>
            <p class="card-text">{{ $estate->description }}</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Stanze: </strong>{{ $estate->rooms }}</li>
            <li class="list-group-item"><strong>Bagni: </strong>{{ $estate->bathrooms }}</li>
            <li class="list-group-item"><strong>Posti Letto: </strong>{{ $estate->beds }}</li>
            <li class="list-group-item"><strong>Metri Quadri: </strong>{{ $estate->mq }}</li>
            <li class="list-group-item"><strong>Prezzo a notte: </strong>{{ $estate->price }} €</li>
        </ul>
    </div>
@endsection
