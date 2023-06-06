@extends('layouts.front')

@section('title')
    Foro
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <center>
                    <a class="ablack titlepage" style="font-size: 50px;" href="{{ url('forum') }}">Bienvenido al foro</a>
                    <hr>
                    <form action="{{ url('searchforum') }}" method="POST">
                        <h3>Busca temas en el foro:</h3>
                        @csrf
                        <div class="input-group w-50">
                            <input type="search" class="form-control custom-searchbar" id="search_forum"
                                placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon1"
                                name="section_name">
                            <button type="submit" class="input-group-text custom-search"><i
                                    class="fa fa-search"></i></button>
                        </div>
                    </form>
                </center>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row mx-md-n5 justify-content-center">
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
            <div class="col-md-8 card color-container mx-md-4">
                <h3 class="text-center mt-4 " style="font-weight: bold">Los mejores posts
                    <hr>
                </h3>
                @foreach ($forum as $post)
                    <div class="card mb-3 color-container">
                        <div class="row no-gutters">
                            <div class="col-md-4 margin d-flex align-items-center justify-content-center">
                                @if (file_exists(public_path('assets/uploads/forum/' . $post->image)) && $post->image != '')
                                    <img src="{{ asset('assets/uploads/forum/' . $post->image) }}" class="image-forum"
                                        alt="{{ $post->title }}">
                                @else
                                    <img src="{{ asset('assets/uploads/forum/noimage.png') }}" class="image-forum"
                                        alt="{{ $post->title }}">
                                @endif
                            </div>
                            <div class="col-md-8">
                                @if (Auth::check())
                                    <?php $userId = Auth::id(); ?>
                                @endif
                                <div class="card-body">
                                    <a class="ablack float-end">{{ $post->created_at->format('d/m/Y') }}</a>
                                    <h4 class="card-title"><a href="{{ url('forum/' . $post->id) }}"
                                            class="ablack">{{ $post->title }}</a></h4>
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ asset('assets/uploads/user/' . $post->user->image) }}"
                                            alt="{{ $post->user->name }} profile image" style="width:30px; height:30px;"
                                            class="rounded-circle me-2">

                                        <h6 class="card-text mb-0">{{ $post->user->username }}</h6>
                                    </div>
                                    <hr>
                                    @if (Auth::check() && $post->user_id == Auth::id())
                                        <a href="{{ url('forum-delete/' . $post->id) }}"
                                            class="btn btn-danger btn-sm float-end">
                                            Borrar Post
                                        </a>
                                    @endif
                                    <h6 style="" class="card-text">Descripción:</h6>
                                    <h5 style="" class="card-text">{{ $post->description }}</h5>
                                    </h6>
                                    @if (isset($userId))
                                        <div class="like-dislike-buttons">
                                            <a href="#" class="like ablack"
                                                onclick="event.preventDefault(); document.getElementById('like-form-{{ $post->id }}').submit();">
                                                <i class="ms-1 fa fa-thumbs-up thumbs-up-green"></i>
                                                {{ isset($likesAndDislikes[$post->id]['likes']) ? $likesAndDislikes[$post->id]['likes'] : 0 }}
                                            </a>

                                            <a href="#" class="dislike ablack"
                                                onclick="event.preventDefault(); document.getElementById('dislike-form-{{ $post->id }}').submit();">
                                                <i class="ms-1 fa fa-thumbs-down thumbs-down-red"></i>
                                                {{ isset($likesAndDislikes[$post->id]['dislikes']) ? $likesAndDislikes[$post->id]['dislikes'] : 0 }}
                                            </a>

                                            <a href="{{ url('forum/' . $post->id) }}"class="ablack">
                                                <i class="ms-1 fa fa-comment"></i>
                                                {{ $CommentsCount[$post->id] ?? 0 }}
                                            </a>


                                            <form id="like-form-{{ $post->id }}"
                                                action="{{ url('forum/' . $post->id . '/like') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                <input type="hidden" name="user_id"
                                                    value="{{ isset($userId) ? $userId : '' }}">
                                            </form>

                                            <form id="dislike-form-{{ $post->id }}"
                                                action="{{ url('forum/' . $post->id . '/dislike') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                <input type="hidden" name="user_id"
                                                    value="{{ isset($userId) ? $userId : '' }}">
                                            </form>
                                        </div>
                                    @else
                                        <a href="#" class="like ablack">
                                            <i class="ms-1 fa fa-thumbs-up thumbs-up-green"></i>
                                            {{ isset($likesAndDislikes[$post->id]['likes']) ? $likesAndDislikes[$post->id]['likes'] : 0 }}
                                        </a>

                                        <a href="#" class="dislike ablack">
                                            <i class="ms-1 fa fa-thumbs-down thumbs-down-red"></i>
                                            {{ isset($likesAndDislikes[$post->id]['dislikes']) ? $likesAndDislikes[$post->id]['dislikes'] : 0 }}
                                        </a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>






    @include('layouts.inc.frontfooter')
@endsection
