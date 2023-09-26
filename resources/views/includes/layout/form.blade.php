<div class="container">
    <form method="POST" action="{{ route('admin.estates.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Title --}}
        <div class="mb-3 col-12 text-start">
            <label for="title">Nome</label>
            <input type="text" id="title" name="title" class="form-control" autofocus required>
        </div>

        {{-- Description --}}
        <div class="mb-3 col-12 text-start">
            <label class="form-label" for="description">Descrizione</label>
            <textarea type="text" id="description" name="description" class="form-control"></textarea>
        </div>

        {{-- Only numbers selectors --}}
        <div class="d-flex row-cols-6">

            {{-- Rooms --}}
            <div class="mb-3 text-start col">
                <label for="rooms">Stanze</label>
                <input type="number" id="rooms" name="rooms" class="form-control" min="1" required>
            </div>

            {{-- Beds --}}
            <div class="mb-3 text-start col">
                <label for="beds">Stanze</label>
                <input type="number" id="beds" name="beds" class="form-control" min="1" required>
            </div>


        </div>
    </form>
</div>
