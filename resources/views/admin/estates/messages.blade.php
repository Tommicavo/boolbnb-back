@extends('layouts.app')
@section('content')
    @Auth
        <div class="mt-5">
            <div>
                <h4>Lista dei messaggi ricevuti</h4>
            </div>
            @forelse($messages as $message)
                <div class="my-1 message-container">
                    <ul class="mb-0">
                        <li class="truncated"><strong>Nome: </strong>{{ $message->name }}...</li>
                        <li class="truncated"><strong>Email: </strong>{{ $message->email }}</li>
                        <li class="truncated"><strong>Testo: </strong>{{ $message->text }}</li>
                    </ul>
                </div>
            @empty
                <h1>Non hai messaggi da leggere</h1>
            @endforelse
        </div>
    @endsection
@endauth
