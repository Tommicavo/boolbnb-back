@extends('layouts.app')
@section('title', 'Messaggi')
@section('content')
    @Auth
        <div class="mt-5">
            @if ($messages->isEmpty())
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Non ci sono messaggi da visualizzare</h3>
                    <a href="{{ route('admin.estates.index') }}" class="btn btn-outline-secondary">
                        <span><i class="fa-solid fa-table-list"></i></span>
                        <span class="d-none d-md-inline"> Torna agli annunci</span>
                    </a>
                </div>
            @else
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Lista dei messaggi ricevuti</h3>
                    <a href="{{ route('admin.estates.index') }}" class="btn btn-outline-secondary">
                        <span><i class="fa-solid fa-table-list"></i></span>
                        <span class="d-none d-md-inline"> Torna agli annunci</span>
                    </a>
                </div>
                <table class="table align-middle table-light">
                    <thead>
                        <tr>
                            <th scope="col">Annuncio</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Email</th>
                            <th scope="col" class="d-none d-md-table-cell">Testo</th>
                            <th scope="col">Data</th>
                            <th scope="col" class="text-center">Visualizza</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                            <tr>
                                <th scope="row">{{ $message->estate->title }}</th>
                                <td>{{ $message->name }}</td>
                                <td>{{ $message->email }}</td>
                                <td class="d-none d-md-table-cell">{{ substr($message->text, 0, 30) }}...</td>
                                <td>{{ $message->created_at }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal"
                                            data-name="{{ $message->name }}" data-title="{{ $message->estate->title }}"
                                            data-email="{{ $message->email }}" data-text="{{ $message->text }}"
                                            data-data="{{ $message->created_at }}">
                                            <span class="d-none d-lg-inline">Dettagli</span>
                                            <span class="d-lg-none"><i class="fa-solid fa-eye"></i></span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endauth
@endsection
@section('scripts')
    @vite(['resources/js/messageModal.js'])
@endsection
