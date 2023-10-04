@extends('layouts.app')
@section('title', 'Messaggi')
@section('content')
    @Auth
        <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Lista dei messaggi ricevuti</h4>
                <a href="{{ route('admin.estates.index') }}" class="btn btn-outline-secondary">
                    <span><i class="fa-solid fa-table-list"></i></span>
                    <span class="d-none d-sm-inline"> Torna agli annunci</span>
                </a>
            </div>
            @forelse($messages as $message)
                <div class="mb-2 message-container" data-bs-toggle="modal" data-bs-target="#myModal"
                    data-name="{{ $message->name }}" data-email="{{ $message->email }}" data-text="{{ $message->text }}">
                    <ul class="mb-0 mx-1">
                        <li class="truncated"><strong>Nome: </strong>{{ $message->name }}</li>
                        <li class="truncated"><strong>Email: </strong>{{ $message->email }}</li>
                        <li class="truncated"><strong>Testo: </strong>{{ $message->text }}</li>
                    </ul>
                </div>
            @empty
                <h1>Non hai messaggi da leggere</h1>
            @endforelse
        </div>
    @endsection
    @section('scripts')
        @vite(['resources/js/messageModal.js'])
    @endsection
@endauth
