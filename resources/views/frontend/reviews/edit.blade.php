@extends('layouts.front')

@section('title', 'Edita tu comentario')

@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card loginbackground">
                    <div class="card-body loginbackground">
                        <h5> Review para {{ $review->section->name }}</h5>
                        <form action=" {{ '/update-review' }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="review_id" value="{{ $review->id }}">
                            <textarea class="form-control" maxlength="300" name="user_review" id="optinion" rows="5"
                                placeholder="Escriu una review">{{ $review->user_review }}</textarea>
                            <small id="character-count-opinion" class="text-muted">300 caracteres restantes</small>
                            <button type="submit" class="btn btn-grad d-flex justify-content-center"> Actualizar
                                comentario</button>
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
