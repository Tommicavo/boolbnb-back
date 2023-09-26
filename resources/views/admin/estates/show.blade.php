@extends('layouts.app')

@section('title', $estate->title)

@section('content')
    <h1 class="mt-3">Dettagli della casa</h1>

    <div class="card my-3">
        <img src="{{ $estate->cover }}" class="card-img-top" alt="{{ $estate->title }}">
        <div class="card-body">
            <h5 class="card-title">{{ $estate->title }}</h5>
            <p class="card-text">{{ $estate->description }}</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Stanze: </strong>{{ $estate->rooms }}</li>
            <li class="list-group-item"><strong>Letti: </strong>{{ $estate->beds }}</li>
            <li class="list-group-item"><strong>Bagni: </strong>{{ $estate->bathrooms }}</li>
            <li class="list-group-item"><strong>Metri Quadri: </strong>{{ $estate->mq }}</li>
            <li class="list-group-item"><strong>Prezzo a notte: </strong>{{ $estate->price }}</li>
            {{-- linea per le categories quando avremo rotta e controller --}}
            {{-- linea per gli users quando avremo rotta e controller --}}
        </ul>
    </div>
    {{-- <footer class="d-flex justify-content-between">
        <a href="{{ route('admin.estates.index') }}" class="btn btn-outline-secondary">Torna alla lista</a>
        <div class="d-flex justify-content-end">
            <a href="{{ route('admin.estates.edit', $post) }}" class="btn btn-outline-warning">
                <i class="fas fa-pencil"></i> Modifica
            </a>
            <form action="{{ route('admin.estates.destroy', $post) }}" method="POST" class="delete-form ms-2">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger">
                    <i class="fas fa-trash"></i> Elimina
                </button>
            </form>
        </div>
    </footer> --}}
@endsection
