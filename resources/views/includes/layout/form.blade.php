<div class="container mt-5 text-start">

    {{-- Dynamic Section --}}
    @if ($estate->exists)
        {{-- Edit section --}}
        <form method="POST" action="{{ route('admin.estates.update', $estate) }}" enctype="multipart/form-data">
            @method('PUT')
        @else
            {{-- Create section --}}
            <form method="POST" action="{{ route('admin.estates.store') }}" enctype="multipart/form-data">
    @endif

    {{-- Token --}}
    @csrf

    {{-- Display Page title --}}
    <h1 class="my-4">
        @if ($estate->exists)
            {{-- Edit section --}}
            Modifica l'annuncio
        @else
            {{-- Create section --}}
            Aggiungi un nuovo annuncio
        @endif
    </h1>

    {{-- Title --}}
    <div class="mb-3 col-12">
        <label for="title">Titolo Annnuncio</label>
        <input type="text" id="title" name="title"
            class="form-control @error('title') is-invalid @elseif (old('title')) is-valid @enderror"
            value="{{ old('title', $estate->title) }}" autofocus required>
        @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Description --}}
    <div class="mb-3 col-12">
        <label class="form-label" for="description">Descrizione</label>
        <textarea type="text" id="description" name="description" class="form-control" maxlength="300">{{ old('description', $estate->description) }}</textarea>
    </div>

    {{-- Address selectors --}}
    <div class="d-flex row justify-content-between">

        {{-- Toponymic --}}
        <div class="mb-3 text-start col-2">
            <label for="toponymic">Via, Piazza, Vicolo...</label>
            <input type="text" id="toponymic" name="toponymic"
                class="form-control @error('toponymic') is-invalid @elseif (old('toponymic')) is-valid @enderror"
                value="{{ old('toponymic', $estate->address) }}" min="1" max="254" required>
            @error('toponymic')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Street name --}}
        <div class="mb-3 text-start col-3">
            <label for="street_name">Nome della via</label>
            <input type="text" id="street_name" name="street_name"
                class="form-control @error('street_name') is-invalid @elseif (old('street_name')) is-valid @enderror"
                value="{{ old('street_name', $estate->address) }}" min="1" max="254" required>
            @error('street_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Number --}}
        <div class="mb-3 text-start col-1">
            <label for="number">Civico</label>
            <input type="number" id="number" name="number"
                class="form-control @error('number') is-invalid @elseif (old('number')) is-valid @enderror"
                value="{{ old('number', $estate->address) }}" min="1" max="500" required>
            @error('number')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Zip Code --}}
        <div class="mb-3 text-start col-1">
            <label for="zip_code">CAP</label>
            <input type="number" id="zip_code" name="zip_code"
                class="form-control @error('zip_code') is-invalid @elseif (old('zip_code')) is-valid @enderror"
                value="{{ old('zip_code', $estate->address) }}" maxlength="5" minlength="5" required>
            @error('zip_code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- City --}}
        <div class="mb-3 text-start col-3">
            <label for="city">Città</label>
            <input type="text" id="city" name="city"
                class="form-control @error('city') is-invalid @elseif (old('city')) is-valid @enderror"
                value="{{ old('city', $estate->address) }}" min="0.01" step="0.01" required>
            @error('city')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    {{-- Only numbers selectors --}}
    <div class="d-flex row justify-content-between">

        {{-- Rooms --}}
        <div class="mb-3 text-start col-2">
            <label for="rooms">Stanze</label>
            <input type="number" id="rooms" name="rooms"
                class="form-control @error('rooms') is-invalid @elseif (old('rooms')) is-valid @enderror"
                value="{{ old('rooms', $estate->rooms) }}" min="1" max="254" required>
            @error('rooms')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Beds --}}
        <div class="mb-3 text-start col-2">
            <label for="beds">Posti Letto</label>
            <input type="number" id="beds" name="beds"
                class="form-control @error('beds') is-invalid @elseif (old('beds')) is-valid @enderror"
                value="{{ old('beds', $estate->beds) }}" min="1" max="254" required>
            @error('beds')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Bathrooms --}}
        <div class="mb-3 text-start col-2">
            <label for="bathrooms">Bagni</label>
            <input type="number" id="bathrooms" name="bathrooms"
                class="form-control @error('bathrooms') is-invalid @elseif (old('bathrooms')) is-valid @enderror"
                value="{{ old('bathrooms', $estate->bathrooms) }}" min="1" max="254" required>
            @error('bathrooms')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Mq --}}
        <div class="mb-3 text-start col-2">
            <label for="mq">Mq</label>
            <input type="number" id="mq" name="mq"
                class="form-control @error('mq') is-invalid @elseif (old('mq')) is-valid @enderror"
                value="{{ old('mq', $estate->mq) }}" min="20" max="1000" required>
            @error('mq')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Price --}}
        <div class="mb-3 text-start col-2">
            <label for="price">Prezzo a Notte</label>
            <input type="number" id="price" name="price"
                class="form-control @error('price') is-invalid @elseif (old('price')) is-valid @enderror"
                value="{{ old('price', $estate->price) }}" min="0.01" step="0.01" required>
            @error('price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>


    {{-- Switch & Checboxes --}}
    <div class="d-flex justify-content-between my-3">
        {{-- Visible switch --}}
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="is_visible" name="is_visible"
                @if ($estate->is_visible) checked @endif>
            <label class="form-check-label" for="is_visible">Visibile per tutti</label>
        </div>

        {{-- Dynamic Services Checkboxes --}}
        <div class="d-flex justify-content-start">
            @foreach ($services as $service)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" @if (in_array($service->id, old('services', $estate_service_ids ?? []))) checked @endif
                        id="tech-{{ $service->id }}" value="{{ $service->id }}" name="services[]">
                    <label class="form-check-label" for="tech-{{ $service->id }}">{{ $service->label }}</label>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Multiple images --}}
    <div class="col-10 text-start">
        <div class="mb-3">
            <label class="form-label" for="multiple_images">Immagini</label>
            <input type="file" multiple id="multiple_images" name="multiple_images[]"
                class="form-control @error('multiple_images') is-invalid @elseif (old('multiple_images')) is-valid @enderror"
                value="{{ old('url', $estate->images) }}">
            @error('multiple_images')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    {{-- !PUT IMAGES HERE --}}

    {{-- Button --}}
    <button class="btn btn-outline-success">
        @if ($estate->exists)
            {{-- Edit section --}}
            Salva
        @else
            {{-- Create section --}}
            Crea
        @endif
    </button>
    </form>
</div>
