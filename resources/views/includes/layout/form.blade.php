<div class="container">
    <form method="POST" action="{{ route('admin.estates.update', $estate) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')



        {{-- Title --}}
        <div class="mb-3 col-12 text-start">
            <label for="title">Nome</label>
            <input type="text" id="title" name="title"
                class="form-control bg-dark @error('title') is-invalid @elseif (old('title')) is-valid @enderror"
                value="{{ old('title', $estate->title) }}" autofocus required>
        </div>

    </form>
</div>
