@extends('layouts.front')

@section('title')
    Foro
@endsection

@section('content')
<body>
    

    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <center>
                    <a class="ablack" style="font-size: 40px" href="{{ url('forum') }}">Foro</a>
                </center>
                <hr>
                <!-- Aquí irá el listado de temas del foro -->
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3 card color-container">
                <h3 style="font-weight: bold" class="text-center mt-4">Categorías
                    <hr>
                </h3>
                <ul class="list-unstyled">
                    @foreach ($categoriesWithCount as $categoryName => $categoryCount)
                        <h4 style="display: flex; justify-content: space-between;">
                            <a class="ablack" href=" {{ url('forum-category/' . $categoryName) }}">{{ $categoryName }}</a>
                            <span class="badge btn-grad align-self-center" style="margin: 0px;">{{ $categoryCount }}</span>
                        </h4>
                    @endforeach
                    @if (empty($categoriesWithCount))
                        <li>No hay categorías</li>
                    @endif
                </ul>
                <hr>
                <h5 class="text-center mt-2">Crea un nuevo tema de conversación:
                </h5>
                <a href="{{ url('add-forum') }}" class="btn btn-grad ">Crear</a>
                <hr>
            </div>

            <div class="col-md-9 card color-container">
                <h3 class="text-center mt-4">Publica un nuevo tema
                    <hr>
                </h3>

                <form action="{{ url('insert-forum') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ optional(Auth::user())->id ?? -1 }}">
                    <label for="title">Selecciona una Categoría: </label>
                    <div class="form-group mb-3">
                        <select class="form-select" name="cate_id">
                            <option value>Selecciona una Categoría</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}"> {{ $item->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="title">Título del tema:</label>
                        <input type="text" class="form-control" id="title" name="title" maxlength="40" required>
                        <small id="character-count-title" class="text-muted">40 caracteres restantes</small>
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">Descripción:</label>
                        <textarea class="form-control" id="description" name="description" maxlength="200" rows="3" required></textarea>
                        <small id="character-count-description" class="text-muted">200 caracteres restantes</small>

                    </div>
                    <div class="form-group mb-3">
                        <label for="image">Imagen:</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                    <button type="submit" class="btn btn-grad">Publicar tema</button>
                </form>
            </div>
        </div>
    </div>

    @include('layouts.inc.frontfooter')
</body>
    <script>
        const description = document.getElementById('description');
        const characterCount = document.getElementById('character-count-description');

        const title = document.getElementById('title');
        const characterCountTitle = document.getElementById('character-count-title');

        description.addEventListener('input', function() {
            const remainingChars = 200 - this.value.length;
            characterCount.textContent = remainingChars + ' caracteres restantes';
        });

        title.addEventListener('input', function() {
            const remainingCharsTitle = 40 - this.value.length;
            characterCountTitle.textContent = remainingCharsTitle + ' caracteres restantes';
        });
    </script>
@endsection
