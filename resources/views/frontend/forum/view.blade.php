@extends('layouts.front')

@section('title')
    Foro
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <center>
                    <a style="font-size: 40px" href="{{ url('forum') }}" class="ablack">Foro</a>
                </center>
                <hr>
                <!-- Aquí irá el listado de temas del foro -->
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


                <div class="mb-3">
                    <div class="row no-gutters">
                        <div class="col-md-4 margin d-flex align-items-center justify-content-center">
                            @if (file_exists(public_path('assets/uploads/forum/' . $forum->image)) & ($forum->image != ''))
                                <img src="{{ asset('assets/uploads/forum/' . $forum->image) }}" class="image-forum"
                                    alt="{{ $forum->title }}">
                            @else
                                <img src="{{ asset('assets/uploads/forum/noimage.png') }}" class="image-forum"
                                    alt="{{ $forum->title }}">
                            @endif
                        </div>

                        <div class="col-md-8">
                            <div class="card-body">
                                <a class="ablack float-end">{{ $forum->created_at->format('d/m/Y') }}</a>
                                <h4 class="card-title">{{ $forum->title }}</h4>
                                <div class="d-flex align-items-center mb-2">
                                    <img src="{{ asset('assets/uploads/user/' . $forum->user->image) }}"
                                        alt="{{ $forum->user->name }} profile image" style="width:30px; height:30px;"
                                        class="rounded-circle me-2">
                                    <p class="card-text">{{ $forum->user->username }}</p>
                                </div>
                                <hr>
                                @if (Auth::check() && $forum->user_id == Auth::id())
                                    <a href="{{ url('forum-delete/' . $forum->id) }}"
                                        class="btn btn-danger btn-sm float-end">
                                        Borrar Post
                                    </a>
                                @endif
                                <p class="card-text">{{ $forum->description }}</p>




                                @if (Auth::check())
                                    <?php $userId = Auth::id(); ?>
                                @endif
                                @if (isset($userId))
                                    <div class="like-dislike-buttons">
                                        <a href="#" class="like ablack"
                                            onclick="event.preventDefault(); document.getElementById('like-form-{{ $forum->id }}').submit();">
                                            <i class="ms-1 fa fa-thumbs-up thumbs-up-green"></i>
                                            {{ isset($forumratio[$forum->id]['likes']) ? $forumratio[$forum->id]['likes'] : 0 }}
                                        </a>

                                        <a href="#" class="dislike ablack"
                                            onclick="event.preventDefault(); document.getElementById('dislike-form-{{ $forum->id }}').submit();">
                                            <i class="ms-1 fa fa-thumbs-down thumbs-down-red"></i>
                                            {{ isset($forumratio[$forum->id]['dislikes']) ? $forumratio[$forum->id]['dislikes'] : 0 }}
                                        </a>
                                        <a class="ablack">
                                            <i class="ms-1 fa fa-comment"></i>
                                            {{ $commentsCount }}
                                        </a>
                                        <form id="like-form-{{ $forum->id }}"
                                            action="{{ url('forum/' . $forum->id . '/like') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            <input type="hidden" name="user_id"
                                                value="{{ isset($userId) ? $userId : '' }}">
                                        </form>

                                        <form id="dislike-form-{{ $forum->id }}"
                                            action="{{ url('forum/' . $forum->id . '/dislike') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            <input type="hidden" name="user_id"
                                                value="{{ isset($userId) ? $userId : '' }}">
                                        </form>
                                    </div>
                                @else
                                    <a href="#" class="like ablack">
                                        <i class="ms-1 fa fa-thumbs-up thumbs-up-green"></i>
                                        {{ isset($forumratio[$forum->id]['likes']) ? $forumratio[$forum->id]['likes'] : 0 }}
                                    </a>

                                    <a href="#" class="dislike ablack">
                                        <i class="ms-1 fa fa-thumbs-down thumbs-down-red"></i>
                                        {{ isset($forumratio[$forum->id]['dislikes']) ? $forumratio[$forum->id]['dislikes'] : 0 }}
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <hr>

                @if (Auth::check())
                    <h2>Publica un nuevo comentario:</h2>
                    <form action="{{ url('insert-comment') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="forum_id" value="{{ $forum->id }}">
                        <div class="mb-3 w-100">
                            <textarea class="form-control w-100" placeholder="Escribe aquí tu comentario" maxlength="200"
                                style="background-color: rgba(255, 255, 255, 0.5);" id="comment" name="comment" rows="3" required></textarea>
                            <small id="character-count-description" class="text-muted">200 caracteres restantes</small>
                            <button type="submit" class="btn-grad"
                                style="border: none; background-color: #e85658; color: white; padding: 10px 20px; border-radius: 5px;">Publicar
                                comentario</button>

                        </div>
                    </form>
                @else
                    <h2>Inicia sesión para poder publicar un comentario: </h2>
                    <a href="{{ url('login') }}" class="btn-grad">Iniciar sesión</a>
                @endif


                @if ($comments->count() > 0)
                    <h2>Comentarios: </h2>
                @else
                    <h2>No hay comentarios</h2>
                @endif
                @foreach ($comments as $item)
                    <div class="card mb-3 mt-2 color-container">
                        <div class="row no-gutters">
                            <div class="col-md-12">
                                <div class="card-body">
                                    @if (Auth::check() && $item->user_id == Auth::id())
                                        <a href="{{ url('forum-delete-comment/' . $item->id) }}"
                                            class="btn btn-danger btn-sm float-end">
                                            Borrar Post
                                        </a>
                                    @endif

                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ asset('assets/uploads/user/' . $item->user->image) }}"
                                            alt="{{ $item->user->name }} profile image" style="width:30px; height:30px;"
                                            class="rounded-circle me-2">
                                        <p class="card-text">{{ $item->user->username }}</p>
                                    </div>

                                    <h5 class="card-title">{{ $item->comment }}</h5>
                                    @if (isset($userId))
                                        <div class="like-dislike-buttons">
                                            <a href="#" class="like ablack"
                                                onclick="event.preventDefault(); document.getElementById('like-form-{{ $item->id }}').submit();">
                                                <i class="ms-1 fa fa-thumbs-up thumbs-up-green"></i>
                                                {{ isset($likesAndDislikes[$item->id]['likes']) ? $likesAndDislikes[$item->id]['likes'] : 0 }}
                                            </a>

                                            <a href="#" class="dislike ablack"
                                                onclick="event.preventDefault(); document.getElementById('dislike-form-{{ $item->id }}').submit();">
                                                <i class="ms-1 fa fa-thumbs-down thumbs-down-red"></i>
                                                {{ isset($likesAndDislikes[$item->id]['dislikes']) ? $likesAndDislikes[$item->id]['dislikes'] : 0 }}
                                            </a>

                                            <form id="like-form-{{ $item->id }}"
                                                action="{{ url('forum-comment/' . $item->id . '/like') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                <input type="hidden" name="user_id"
                                                    value="{{ isset($userId) ? $userId : '' }}">
                                            </form>

                                            <form id="dislike-form-{{ $item->id }}"
                                                action="{{ url('forum-comment/' . $item->id . '/dislike') }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                <input type="hidden" name="user_id"
                                                    value="{{ isset($userId) ? $userId : '' }}">
                                            </form>
                                        </div>
                                    @else
                                        <a href="#" class="like ablack">
                                            <i class="ms-1 fa fa-thumbs-up thumbs-up-green"></i>
                                            {{ isset($likesAndDislikes[$item->id]['likes']) ? $likesAndDislikes[$item->id]['likes'] : 0 }}
                                        </a>

                                        <a href="#" class="dislike ablack">
                                            <i class="ms-1 fa fa-thumbs-down thumbs-down-red"></i>
                                            {{ isset($likesAndDislikes[$item->id]['dislikes']) ? $likesAndDislikes[$item->id]['dislikes'] : 0 }}
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

    <script>
        const description = document.getElementById('comment');
        const characterCount = document.getElementById('character-count-description');

        description.addEventListener('input', function() {
            const remainingChars = 200 - this.value.length;
            characterCount.textContent = remainingChars + ' caracteres restantes';
        });
    </script>
@endsection
