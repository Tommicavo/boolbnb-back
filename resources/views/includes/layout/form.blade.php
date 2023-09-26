<div class="container mt-5 text-start">
    <form method="POST" action="{{ route('admin.estates.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Title --}}
        <div class="mb-3 col-12">
            <label for="title">Nome</label>
            <input type="text" id="title" name="title" class="form-control" autofocus required>
        </div>

        {{-- Description --}}
        <div class="mb-3 col-12">
            <label class="form-label" for="description">Descrizione</label>
            <textarea type="text" id="description" name="description" class="form-control"></textarea>
        </div>

        {{-- Only numbers selectors --}}
        <div class="d-flex flex-column row-cols-6 justify-content-between">

            {{-- Rooms --}}
            <div class="mb-3 text-start col">
                <label for="rooms">Stanze</label>
                <input type="number" id="rooms" name="rooms" class="form-control" min="1" required>
            </div>

            {{-- Beds --}}
            <div class="mb-3 text-start col">
                <label for="beds">Posti Letto</label>
                <input type="number" id="beds" name="beds" class="form-control" min="1" required>
            </div>

            {{-- Bathrooms --}}
            <div class="mb-3 text-start col">
                <label for="bathrooms">Bagni</label>
                <input type="number" id="bathrooms" name="bathrooms" class="form-control" min="1" required>
            </div>

            {{-- Mq --}}
            <div class="mb-3 text-start col">
                <label for="mq">Mq</label>
                <input type="number" id="mq" name="mq" class="form-control" min="20" required>
            </div>

            {{-- Price --}}
            <div class="mb-3 text-start col">
                <label for="price">Prezzo a Notte</label>
                <input type="number" id="price" name="price" class="form-control" min="20" required>
            </div>
        </div>

        {{-- Visible switch --}}
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="is_visible" name="is_visible" checked>
            <label class="form-check-label" for="is_visible">Visibile per tutti</label>
        </div>

        {{-- Image/cover iput --}}
        <div class="col-10 text-start">
            <div class="mb-3">
                <label class="form-label" for="cover">Immagine</label>
                <input type="file" id="cover" name="cover" class="form-control" required>
            </div>
        </div>

        {{-- Button --}}
        <button class="btn btn-outline-success">
            Crea
        </button>
    </form>
</div>
