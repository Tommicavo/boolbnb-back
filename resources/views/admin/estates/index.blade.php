@extends('layouts.app')

@section('title', 'Annunci')
@section('content')
    <header class="d-flex justify-content-between align-items-center">
        <h1 class="text-center py-3">Alloggi</h1>
        <div class="headerRight">
            <a href="{{ route('admin.estates.create') }}" class="btn btn-success">
                <span><i class="fa-regular fa-square-plus"></i></span>
                <span class="d-none d-md-inline">Aggiungi un alloggio</span>
            </a>
            <a href="{{ route('admin.estates.messages') }}" class="btn btn-primary">
                <span><i class="fa-regular fa-envelope"></i></span>
                <span class="d-none d-md-inline">Messaggi</span>
            </a>
            <a href="{{ route('admin.estates.trash') }}" class="btn btn-danger">
                <span><i class="fa-solid fa-trash-arrow-up"></i></span>
                <span class="d-none d-md-inline">Cestino</span>
            </a>
        </div>
    </header>
    <div class="indexContent">
        <table class="table mt-3 align-middle table-light">
            <thead>
                <tr>
                    <th scope="col">Alloggio</th>
                    <th scope="col" class="text-center d-none d-md-table-cell">Stanze</th>
                    <th scope="col" class="text-center d-none d-lg-table-cell">Letti</th>
                    <th scope="col" class="text-center d-none d-lg-table-cell">Bagni</th>
                    <th scope="col" class="text-center d-none d-md-table-cell">Superficie</th>
                    <th scope="col" class="text-center">Prezzo</th>
                    <th scope="col" class="text-center">Visibile</th>
                    <th scope="col" class="text-center">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estates as $estate)
                    @if (Auth::id() === $estate->user_id)
                        <tr>
                            <th>{{ $estate->title }}</th>
                            <td class="text-center d-none d-md-table-cell">{{ $estate->rooms }}</td>
                            <td class="text-center d-none d-lg-table-cell">{{ $estate->beds }}</td>
                            <td class="text-center d-none d-lg-table-cell">{{ $estate->bathrooms }}</td>
                            <td class="text-center d-none d-md-table-cell">{{ $estate->mq }} m²</td>
                            <td class="text-center">{{ $estate->price }} €</td>
                            <td class="text-center">
                                @if ($estate->is_visible)
                                    SI
                                @else
                                    NO
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a class="btn btn-dark me-2 me-md-3" href="{{ route('admin.estates.promo', $estate) }}">
                                        <span class="d-none d-lg-inline">Promuovi</span>
                                        <span class="d-lg-none"><i class="fa-solid fa-comment-dollar"></i></span>
                                    </a>
                                    <a class="btn btn-info text-white" href="{{ route('admin.estates.show', $estate) }}">
                                        <span class="d-none d-lg-inline">Dettagli</span>
                                        <span class="d-lg-none"><i class="fa-solid fa-circle-info"></i></span>
                                    </a>
                                    <a class="btn btn-warning text-white mx-2 mx-md-3"
                                        href="{{ route('admin.estates.edit', $estate) }}">
                                        <span class="d-none d-lg-inline">Modifica</span>
                                        <span class="d-lg-none"><i class="fa-solid fa-wrench"></i></span>
                                    </a>

                                    <form action="{{ route('admin.estates.destroy', $estate) }}" method="POST"
                                        class="deleteForm trashEstate" data-name="{{ $estate->title }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit" data-bs-toggle="modal"
                                            data-bs-target="#myModal">
                                            <span class="d-none d-lg-inline">Elimina</span>
                                            <span class="d-lg-none"><i class="fa-solid fa-trash-can"></i></span>
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
