@extends('layouts.app')

@section('title', 'Home')
@section('content')
<div class="d-flex justify-content-end mt-3">
  </div>
  <table class="table mt-3">
    <thead>
      <tr>
        <th scope="col">Alloggio</th>
        
        
        <th scope="col">Descrizione</th>
        
        
      </tr>
    </thead>
    <tbody>
      @foreach ($estates as $estate)
        <tr>
          <th>{{ $estate->title }}</th>
          <td>{{ $estate->description }}</td>
          <td>{{ $estate->cover }}</td>
          <td>{{ $estate->rooms }}</td>
          <td>{{ $estate->beds }}</td>
          <td>{{ $estate->bathrooms }}</td>
          <td>{{ $estate->mq }}</td>
          <td>{{ $estate->price }}</td>
          <td>{{ $estate->is_visible }}</td>
          <td>
            <div class="d-flex justify-content-end">
                
                <a class="btn btn-primary" href="" >Crea</a>
              <a class="btn btn-success" href="{{ route('admin.estates.show', $estate) }}">Dettagli</a>
              <a class="btn btn-warning mx-3" href="{{ route('admin.estates.edit', $estate) }}">Modifica</a>
              <form action="{{ route('admin.estates.destroy', $estate) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger">Cancella</button>
              </form>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection