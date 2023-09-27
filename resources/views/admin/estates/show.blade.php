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
        <div class="images-section d-flex justify-content-center">
            <div class="box-cover">
                <img src="{{ $estate->get_cover_path() }}" alt="{{ $estate->title }}">
            </div>
            <div class="boxes d-flex flex-column flex-wrap">
                @foreach ($estate->images as $index => $image)
                    @if ($index > 0)
                        <div class="box"><img src="{{ asset('storage/' . $image->url) }}" alt=""></div>
                    @endif
                @endforeach

            </div>
        </div>

        <div class="card-body">
            <h5 class="card-title">{{ $estate->title }}</h5>
            <p class="card-text">{{ $estate->description }}</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Indirizzo: </strong>{{ $estate->get_address() }}</li>
            <li class="list-group-item"><strong>Stanze: </strong>{{ $estate->rooms }}</li>
            <li class="list-group-item"><strong>Bagni: </strong>{{ $estate->bathrooms }}</li>
            <li class="list-group-item"><strong>Posti Letto: </strong>{{ $estate->beds }}</li>
            <li class="list-group-item"><strong>Metri Quadri: </strong>{{ $estate->mq }}</li>
            <li class="list-group-item"><strong>Prezzo a notte: </strong>{{ $estate->price }} €</li>
            <li class="list-group-item d-flex"><strong>servizi: </strong>
                @forelse($estate->services as $service)
                    <div class="service p-1 d-flex flex-column mx-2">
                        <h5 class="card-title text-center pb-3"> {{ $service?->label }}</h5>
                        <i class="text-center fa-solid fa-{{ $service->icon }} fa-2xl"></i>
                    </div>

                @empty
                    -
                @endforelse

            </li>

        </ul>
    </div>

@endsection
