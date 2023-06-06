@extends('layouts.front')

@section('title', 'Escriu un comentari')

@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card loginbackground">
                    <div class="card-body ">
                        <h5> Review para {{ $section->name }}</h5>
                        <form action=" {{ '/add-review' }}" method="POST">
                            @csrf
                            <input type="hidden" name="section_id" value="{{ $section->id }}">
                            <textarea class="form-control" id="opinion" name="user_review" maxlength="300" rows="5"
                                placeholder="Escriu una review"></textarea>
                            <small id="character-count-opinion" class="text-muted">300 caracteres restantes</small>
                            <button type="submit" class="btn btn-grad d-flex"> Publicar comentario</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        const opinion = document.getElementById('opinion');
        const characterCount = document.getElementById('character-count-opinion');


        opinion.addEventListener('input', function() {
            const remainingChars = 300 - this.value.length;
            characterCount.textContent = remainingChars + ' caracteres restantes';
        });
    </script>
@endsection
