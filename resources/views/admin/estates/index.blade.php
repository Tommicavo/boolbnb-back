@extends('layouts.app')

@section('title', 'Home')
@section('content')
    <header class="d-flex justify-content-between align-items-center">
        <h1 class="text-center py-3">Alloggi</h1>
        <div class="headerRight">
            <a href="{{ route('admin.estates.create') }}" class="btn btn-success">
                <span><i class="fa-regular fa-square-plus"></i></span>
                <span>Aggiungi un alloggio</span>
            </a>
            <a href="{{ route('admin.estates.trash') }}" class="btn btn-danger">
                <span><i class="fa-solid fa-trash-arrow-up"></i></span>
                <span>Cestino</span>
            </a>
        </div>
    </header>
    <div class="indexContent">
        <table class="table mt-3">
            <thead>
                <tr>
                    <th scope="col">Alloggio</th>
                    <th scope="col">Stanze</th>
                    <th scope="col">Letti</th>
                    <th scope="col">Bagni</th>
                    <th scope="col">Superficie</th>
                    <th scope="col">Prezzo</th>
                    <th scope="col">Visibile</th>
                    <th scope="col" class="text-center">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estates as $estate)
                    @if (Auth::id() === $estate->user_id)
                        <tr>
                            <th>{{ $estate->title }}</th>
                            <td>{{ $estate->rooms }}</td>
                            <td>{{ $estate->beds }}</td>
                            <td>{{ $estate->bathrooms }}</td>
                            <td>{{ $estate->mq }}</td>
                            <td>{{ $estate->price }}</td>
                            <td>{{ $estate->is_visible }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a class="btn btn-primary"
                                        href="{{ route('admin.estates.show', $estate) }}">Dettagli</a>
                                    <a class="btn btn-warning mx-3"
                                        href="{{ route('admin.estates.edit', $estate) }}">Modifica</a>
                                    <form action="{{ route('admin.estates.destroy', $estate) }}" method="POST"
                                        class="deleteForm trashEstate" data-name="{{ $estate->title }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit" data-bs-toggle="modal"
                                            data-bs-target="#myModal">
                                            Elimina
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/modalScript.js'])
@endsection
