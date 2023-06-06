@extends('layouts.front')

@section('title', $section->name)

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="  {{ url('/add-rating') }} " method="POST">
                    @csrf
                    <input type="hidden" name="section_id" value="{{ $section->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Puntúa {{ $section->name }} </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="rating-css">
                            <div class="star-icon">
                                @if ($user_rating)
                                    @for ($i = 1; $i <= $user_rating->stars_rated; $i++)
                                        <input type="radio" value=" {{ $i }}" name="section_rating" checked
                                            id="rating{{ $i }}">
                                        <label for="rating{{ $i }}" class="fa fa-star"></label>
                                    @endfor
                                    @for ($j = $user_rating->stars_rated + 1; $j <= 5; $j++)
                                        <input type="radio" value=" {{ $j }}" name="section_rating"
                                            id="rating{{ $j }}">
                                        <label for="rating{{ $j }}" class="fa fa-star"></label>
                                    @endfor
                                @else
                                    <input type="radio" value="1" name="section_rating" checked id="rating1">
                                    <label for="rating1" class="fa fa-star"></label>
                                    <input type="radio" value="2" name="section_rating" id="rating2">
                                    <label for="rating2" class="fa fa-star"></label>
                                    <input type="radio" value="3" name="section_rating" id="rating3">
                                    <label for="rating3" class="fa fa-star"></label>
                                    <input type="radio" value="4" name="section_rating" id="rating4">
                                    <label for="rating4" class="fa fa-star"></label>
                                    <input type="radio" value="5" name="section_rating" id="rating5">
                                    <label for="rating5" class="fa fa-star"></label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Puntuar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="py-2 mb-4 shadow-sm">
        <div class="container">
            <a style="color: black; font-weight: ;" href="{{ url('category/') }}">
                Categoría /
            </a>
            <a style="color: black; font-weight: ;" href="{{ url('category/' . $section->category->name) }}">
                {{ $section->category->name }} /
            </a>

            <a style="color: black; font-weight: ;"
                href="{{ url('category/' . $section->category->name . '/' . $section->name) }}">
                {{ $section->name }}
            </a>

        </div>
    </div>



    <div class="containera">
        <div id="sidebar" class="card shadow text-center ">
            <img src="{{ asset('assets/uploads/section/4/' . $noticia->image) }}" alt="Imagen no disponible."
                class="card-img-top " style="max-width: 100%; height: auto; width: 400px; max-height: 400px;">
            <div class="card-body">
                <h3 class="card-title">{{ $noticia->name }}</h3>

                <ul class="list-unstyled">
                    <li class="my-3">
                        <a>{{ $noticia->small_description }}</a>
                        <div class="d-flex justify-content-center">
                            <a href="{{ url('category/Noticias/' . $noticia->name) }}" type="submit"
                                class="btn btn-grad mt-4"> Ver
                                noticia</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <main class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">

                        <div class="d-flex flex-column" style="max-height: 400px;">
                            <div class="d-flex align-items-center justify-content-center mt-4">
                                <img src="{{ asset('assets/uploads/section/' . $section->cate_id . '/' . $section->position . '.jpg') }}"
                                    alt="{{ $section->name }}" class="img-fluid"
                                    style="max-width: 100%; height: auto; width: 300px; max-height: 300px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 mt-2">
                        <div class="align-items-end">
                            @if ($section->trending == '1')
                                <div class="ml-auto">
                                    <label style="font-size: 16px;"
                                        class="badge bg-danger float-end trending_tag mt-2">Trending</label>
                                </div>
                            @endif
                        </div>
                        @if ($section->cate_id == 3)
                            <a href="https://open.spotify.com/search/{{ $section->small_description }}" target="_blank"
                                class="float-end me-2">
                                <img style="height: 40px" src="{{ url('assets/logo/spotify.png') }}">
                            </a>
                        @else
                            <a href="https://open.spotify.com/search/{{ $section->name }}" target="_blank"
                                class="float-end me-2">
                                <img style="height: 40px" src="{{ url('assets/logo/spotify.png') }}">
                            </a>
                        @endif
                        <div class="align-items-center">
                            <h1 class="mb-0">{{ $section->name }}</h1>
                            <h3 class="mt-2">{{ $section->small_description }}</h3>
                        </div>
                        <hr>
                        <label class="fw-bold">Palabras clave: {{ $section->meta_keywords }}</label>

                        @php $ratenumber = number_format($rating_value) @endphp
                        <div class="rating">
                            @for ($i = 1; $i <= $ratenumber; $i++)
                                <i class="fa fa-star checked"></i>
                            @endfor
                            @for ($j = $ratenumber + 1; $j <= 5; $j++)
                                <i class="fa fa-star-o"></i>
                            @endfor

                            <span>
                                @if ($rating->count() > 0)
                                    {{ $rating->count() }} Valoraciones
                                @else
                                    No hay valoraciones
                                @endif
                            </span>

                        </div>

                        <hr>
                        <div>
                            {{ $section->description }}
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <a href="{{ url('add-review/' . $section->name . '/userreview') }}"
                                    class="btn btn-grad d-flex justify-content-center">
                                    Comentar
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a class="btn btn-grad d-flex justify-content-center" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    Puntuar
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        @foreach ($reviews as $item)
                            <div class="float-end">
                                @if ($item->user_id == Auth::id())
                                    <a class="btn btn-grad2 " style="width: 20%, height:2%"
                                        href="{{ url('edit-review/' . $section->name . '/userreview') }}">Editar</a>
                                    <a class="btn btn-del" href="{{ url('delete-review/' . $item->id) }}">Borrar</a>
                                @endif

                            </div>

                            @php
                                $rating = App\Models\Rating::where('section_id', $section->id)
                                    ->where('user_id', $item->user->id)
                                    ->first();
                            @endphp

                            <div class="d-flex align-items-center mb-2">
                                <img src="{{ asset('assets/uploads/user/' . $item->user->image) }}"
                                    alt="{{ $item->user->name }} profile image" style="width:30px; height:30px;"
                                    class="rounded-circle me-2">
                                <h5 class="mb-1 me-2">{{ $item->user->username }}</h5>
                            </div>
                            @if ($rating)
                                @php
                                    $user_rated = $rating->stars_rated;
                                @endphp
                                <div class="d-flex align-items-center mb-2 justify-content-start">
                                    @for ($i = 1; $i <= $user_rated; $i++)
                                        <i class="fa fa-star checked"></i>
                                    @endfor
                                    @for ($j = $user_rated + 1; $j <= 5; $j++)
                                        <i class="fa fa-star-o"></i>
                                    @endfor
                                </div>
                            @endif

                            <label>Comentario hecho el {{ $item->created_at->format('d M Y') }}</label>
                            <p class="mt-2">{{ $item->user_review }}</p>
                            <hr>
                        @endforeach
                    </div>
                </div>

        </main>

        <div id="sidebar2" class="shadow text-center ">
            <img src="{{ asset('assets/uploads/section/4/' . $noticia2->image) }}" alt="Imagen no disponible."
                class="card-img-top " style="max-width: 100%; height: auto; width: 400px; max-height: 400px;">
            <div class="card-body">
                <h3 class="card-title">{{ $noticia2->name }}</h3>

                <ul class="list-unstyled">
                    <li class="my-3">
                        <a>{{ $noticia2->small_description }}</a>
                        <div class="d-flex justify-content-center">
                            <a href="{{ url('category/Noticias/' . $noticia2->name) }}" type="submit"
                                class="btn btn-grad mt-4"> Ver
                                noticia</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>


    </div>



    @include('layouts.inc.frontfooter')


@endsection
