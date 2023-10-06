@extends('layouts.app')
@section('title', $estate->title)
@section('content')
    <div class="d-flex justify-content-between align-items-center my-3">
        <h1>Dettagli annuncio</h1>
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.estates.index') }}" class="btn btn-outline-secondary">
                <span><i class="fa-solid fa-table-list"></i></span>
                <span class="d-none d-md-inline"> Torna agli annunci</span>
            </a>
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.estates.edit', $estate) }}" class="btn btn-outline-warning mx-2">
                    <span><i class="fas fa-pencil"></i></span>
                    <span class="d-none d-md-inline"> Modifica</span>
                </a>
                <form action="{{ route('admin.estates.destroy', $estate) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger">
                        <span><i class="fas fa-trash"></i></span>
                        <span class="d-none d-md-inline"> Elimina</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card mb-3">
        @if (count($estate->images))
            <img style="height: 26rem; object-fit: cover;" src="{{ $estate->get_cover_path() }}" class="card-img-top"
                alt="{{ $estate->title }}">
        @endif
        <div class="card-body">
            <h5 class="card-title">{{ $estate->title }}</h5>
            <p class="card-text">{{ $estate->description }}</p>
        </div>
        <div class="d-flex justify-content-between">
            <div class="list">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Indirizzo: </strong>{{ $estate->address }}</li>
                    <li class="list-group-item"><strong>Stanze: </strong>{{ $estate->rooms }}</li>
                    <li class="list-group-item"><strong>Bagni: </strong>{{ $estate->bathrooms }}</li>
                    <li class="list-group-item"><strong>Posti Letto: </strong>{{ $estate->beds }}</li>
                    <li class="list-group-item"><strong>Metri Quadri: </strong>{{ $estate->mq }} m²</li>
                    <li class="list-group-item"><strong>Prezzo a notte: </strong>{{ $estate->price }} €</li>
                    <li class="list-group-item d-flex align-items-center justify-content-between">
                        <div><strong>Servizi: </strong></div>
                        <div class="d-flex flex-wrap justify-content-start">
                            @forelse($estate->services as $service)
                                <div class="service d-flex flex-column just m-1 p-1">
                                    <span class="card-title text-center pb-2"> {{ $service?->label }}</span>
                                    <i class="text-center fa-solid fa-{{ $service->icon }} fa-xl"></i>
                                </div>
                            @empty
                                -
                            @endforelse
                        </div>
                    </li>
                </ul>
            </div>
            <div class="charts">
                <canvas id="myChart" data-type="detail" data-visits="{{ $visitsData }}"></canvas>
            </div>
        </div>
    </div>

    <div class="result">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>

@endsection
@section('scripts')
    {{-- @vite(['resources/js/charts.js']) --}}
@endsection
