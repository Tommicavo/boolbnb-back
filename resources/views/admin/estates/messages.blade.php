@extends('layouts.app')
@section('title', 'Messaggi')
@section('content')
    @Auth
        <div class="mt-5">
            @if ($messages->isEmpty())
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Non ci sono messaggi da visualizzare</h3>
                    <a href="{{ route('admin.estates.index') }}" class="bt bt-dark-g">
                        <span><i class="fa-solid fa-table-list"></i></span>
                        <span class="d-none d-md-inline"> Torna agli annunci</span>
                    </a>
                </div>
            @else
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Lista dei messaggi ricevuti</h3>
                    <a href="{{ route('admin.estates.index') }}" class="bt bt-dark-g">
                        <span><i class="fa-solid fa-table-list"></i></span>
                        <span class="d-none d-md-inline"> Torna agli annunci</span>
                    </a>
                </div>
                <div class="d-flex justify-content-center">
                    <table>
                        <thead>
                            <tr>
                                <th class="ps-1 pe-3"><i class="fa-solid fa-camera-retro"></i> Pic</th>
                                <th class="pe-3"><i class="fa-solid fa-house"></i> Annuncio</th>
                                <th class="pe-3"><i class="fa-solid fa-user"></i> Nome</th>
                                <th class="pe-3"><i class="fa-solid fa-envelope"></i> Email</th>
                                <th class="d-none d-md-table-cell pe-3"><i class="fa-solid fa-file-lines"></i> Testo</th>
                                <th class="pe-3"><i class="fa-solid fa-calendar-days"></i> Data e Ora</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                                <tr data-bs-toggle="modal" data-bs-target="#myModal" data-content="{{ $message }}"
                                    data-title="{{ $message->estate->title }}">
                                    <th class="pt-1"><img width="50px" height="50px" class="rounded"
                                            src="{{ $message->estate->get_cover_path() }}" alt="{{ $message->estate->title }}">
                                    </th>
                                    <th class="px-1">{{ $message->estate->title }}</th>
                                    <td class="px-1">{{ $message->name }}</td>
                                    <td class="px-1">{{ $message->email }}</td>
                                    <td class="px-1" class="d-none d-md-table-cell">
                                        {{ substr($message->text, 0, 30) }}...
                                    </td>
                                    <td class="px-1">{{ $message->created_at->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endauth
@endsection
@section('scripts')
    @vite(['resources/js/messageModal.js'])
@endsection
