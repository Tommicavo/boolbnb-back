@extends('layouts.app')

@section('title', 'Trash Can')

@section('content')
    <header class="d-flex justify-content-between align-items-center py-4">
        <h1>Trash Can</h1>
        <div class="headerLeft d-flex justify-content-center align-items-center gap-3">
            <a class="btn btn-primary" href="{{ route('admin.home') }}">
                <span><i class="fa-solid fa-house-user"></i></span>
                <span>Home</span>
            </a>
            <a class="btn btn-primary" href="{{ route('admin.estates.index') }}">
                <span><i class="fa-solid fa-backward-fast"></i></span>
                <span>Estates</span>
            </a>
            <form action="{{ route('admin.estates.restoreAll') }}" method="POST">
                @csrf
                @method('PATCH')
                <button class="btn btn-success" type="submit">
                    <span><i class="fa-solid fa-recycle"></i></span>
                    <span>Restore All</span>
                </button>
            </form>
            <form action="{{ route('admin.estates.dropAll') }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit">
                    <span><i class="fa-solid fa-explosion"></i></span>
                    <span>Erase All</span>
                </button>
            </form>
        </div>
    </header>
    <div class="trashContent">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" width="20%">#</th>
                    <th scope="col" width="50%">Estate</th>
                    <th scope="col" width="30%" class="text-center">Tasks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estates as $estate)
                    <tr>
                        <td> {{ $estate->id }} </td>
                        <td> {{ $estate->title }} </td>
                        <td>
                            <div class="trashButtons d-flex justify-content-center align-items-center gap-3">
                                <form action="{{ route('admin.estates.restore', $estate->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success" type="submit">
                                        <span><i class="fa-solid fa-recycle"></i></span>
                                        <span>Restore</span>
                                    </button>
                                </form>
                                <a class="btn btn-primary" href="{{ route('admin.estates.show', $estate->id) }}">
                                    <span><i class="fa-solid fa-info"></i></span>
                                    <span>Info</span>
                                </a>
                                <form action="{{ route('admin.estates.drop', $estate->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">
                                        <span><i class="fa-solid fa-trash-can"></i></span>
                                        <span>Erase</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
