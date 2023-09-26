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
            Modifica l'appartamento
        @else
            {{-- Create section --}}
            Aggiungi un nuovo appartamento
        @endif
    </h1>

    {{-- Title --}}
    <div class="mb-3 col-12">
        <label for="title">Nome</label>
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
        <textarea type="text" id="description" name="description" class="form-control">{{ old('description', $estate->description) }}</textarea>
    </div>

    {{-- Only numbers selectors --}}
    <div class="d-flex flex-column row-cols-6 justify-content-between">

        {{-- Rooms --}}
        <div class="mb-3 text-start col">
            <label for="rooms">Stanze</label>
            <input type="number" id="rooms" name="rooms"
                class="form-control @error('rooms') is-invalid @elseif (old('rooms')) is-valid @enderror"
                value="{{ old('rooms', $estate->rooms) }}" min="1" required>
            @error('rooms')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Beds --}}
        <div class="mb-3 text-start col">
            <label for="beds">Posti Letto</label>
            <input type="number" id="beds" name="beds"
                class="form-control @error('beds') is-invalid @elseif (old('beds')) is-valid @enderror"
                value="{{ old('beds', $estate->beds) }}" min="1" required>
            @error('beds')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Bathrooms --}}
        <div class="mb-3 text-start col">
            <label for="bathrooms">Bagni</label>
            <input type="number" id="bathrooms" name="bathrooms"
                class="form-control @error('bathrooms') is-invalid @elseif (old('bathrooms')) is-valid @enderror"
                value="{{ old('bathrooms', $estate->bathrooms) }}" min="1" required>
            @error('bathrooms')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Mq --}}
        <div class="mb-3 text-start col">
            <label for="mq">Mq</label>
            <input type="number" id="mq" name="mq"
                class="form-control @error('mq') is-invalid @elseif (old('mq')) is-valid @enderror"
                value="{{ old('mq', $estate->mq) }}" min="20" required>
            @error('mq')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Price --}}
        <div class="mb-3 text-start col">
            <label for="price">Prezzo a Notte</label>
            <input type="number" id="price" name="price"
                class="form-control @error('price') is-invalid @elseif (old('price')) is-valid @enderror"
                value="{{ old('price', $estate->price) }}" min="20" required>
            @error('price')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    {{-- Visible switch --}}
    <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" id="is_visible" name="is_visible" checked>
        <label class="form-check-label" for="is_visible">Visibile per tutti</label>
    </div>

    {{-- Dynamic Services Checkboxes --}}
    <div class="d-flex justify-content-start my-5">
        @foreach ($services as $service)
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" @if (in_array($service->id, old('services', $estate_service_ids ?? []))) checked @endif
                    id="tech-{{ $service->id }}" value="{{ $service->id }}" name="services[]">
                <label class="form-check-label" for="tech-{{ $service->id }}">{{ $service->label }}</label>
            </div>
        @endforeach
    </div>

    {{-- Image/cover input --}}
    <div class="col-10 text-start">
        <div class="mb-3">
            <label class="form-label" for="cover">Immagine</label>
            <input type="file" id="cover" name="cover"
                class="form-control @error('cover') is-invalid @elseif (old('cover')) is-valid @enderror"
                value="{{ old('cover', $estate->cover) }}" required>
        </div>
        @error('cover')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

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
