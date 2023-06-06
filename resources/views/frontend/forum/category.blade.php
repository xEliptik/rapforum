@extends('layouts.front')

@section('title')
    Foro
@endsection

@section('content')
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
                <h3 class="text-center mt-4">Posts de {{ $category->name }}
                    <hr>
                </h3>
                @if (count($forums) > 0)
                    @foreach ($forums as $forum_item)
                        <div class="card mb-3 color-container">
                            <div class="row no-gutters">
                                <div class="col-md-4 margin d-flex align-items-center justify-content-center">
                                    @if (file_exists(public_path('assets/uploads/forum/' . $forum_item->image)) & ($forum_item->image != ''))
                                        <img src="{{ asset('assets/uploads/forum/' . $forum_item->image) }}"
                                            class="image-forum" alt="{{ $forum_item->title }}">
                                    @else
                                        <img src="{{ asset('assets/uploads/forum/noimage.png') }}" class="image-forum"
                                            class="image-forum" alt="{{ $forum_item->title }}">
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <a class="ablack float-end">{{ $forum_item->created_at->format('d/m/Y') }}</a>
                                        <a href=" {{ url('forum/' . $forum_item->id) }}"
                                            class="card-title posttitle ablack">{{ $forum_item->title }}</a>
                                        <div class="d-flex align-items-center mb-2">
                                            <img src="{{ asset('assets/uploads/user/' . $forum_item->user->image) }}"
                                                alt="{{ $forum_item->user->name }} profile image"
                                                style="width:30px; height:30px;" class="rounded-circle me-2">
                                            <p class="card-text">{{ $forum_item->user->username }}</p>

                                        </div>
                                        <hr>
                                        @if (Auth::check() && $forum_item->user_id == Auth::id())
                                            <a href="{{ url('forum-delete/' . $forum_item->id) }}"
                                                class="btn btn-danger btn-sm float-end">
                                                Borrar Post
                                            </a>
                                        @endif
                                        <h6 class="card-text">{{ $forum_item->description }}</h6>
                                        @if (Auth::check())
                                            <?php $userId = Auth::id(); ?>
                                        @endif
                                        @if (isset($userId))
                                            <div class="like-dislike-buttons">
                                                <a href="#" class="like ablack"
                                                    onclick="event.preventDefault(); document.getElementById('like-form-{{ $forum_item->id }}').submit();">
                                                    <i class="ms-1 fa fa-thumbs-up thumbs-up-green"></i>
                                                    {{ isset($likesAndDislikes[$forum_item->id]['likes']) ? $likesAndDislikes[$forum_item->id]['likes'] : 0 }}
                                                </a>

                                                <a href="#" class="dislike ablack"
                                                    onclick="event.preventDefault(); document.getElementById('dislike-form-{{ $forum_item->id }}').submit();">
                                                    <i class="ms-1 fa fa-thumbs-down thumbs-down-red"></i>
                                                    {{ isset($likesAndDislikes[$forum_item->id]['dislikes']) ? $likesAndDislikes[$forum_item->id]['dislikes'] : 0 }}
                                                </a>

                                                <a href="{{ url('forum/' . $forum_item->id) }}"class="ablack">
                                                    <i class="ms-1 fa fa-comment"></i>
                                                    {{ $CommentsCount[$forum_item->id] ?? 0 }}
                                                </a>

                                                <form id="like-form-{{ $forum_item->id }}"
                                                    action="{{ url('forum/' . $forum_item->id . '/like') }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="user_id"
                                                        value="{{ isset($userId) ? $userId : '' }}">
                                                </form>

                                                <form id="dislike-form-{{ $forum_item->id }}"
                                                    action="{{ url('forum/' . $forum_item->id . '/dislike') }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="user_id"
                                                        value="{{ isset($userId) ? $userId : '' }}">
                                                </form>
                                            </div>
                                        @else
                                            <a href="#" class="like ablack">
                                                <i class="ms-1 fa fa-thumbs-up thumbs-up-green"></i>
                                                {{ isset($likesAndDislikes[$forum_item->id]['likes']) ? $likesAndDislikes[$forum_item->id]['likes'] : 0 }}
                                            </a>

                                            <a href="#" class="dislike ablack">
                                                <i class="ms-1 fa fa-thumbs-down thumbs-down-red"></i>
                                                {{ isset($likesAndDislikes[$forum_item->id]['dislikes']) ? $likesAndDislikes[$forum_item->id]['dislikes'] : 0 }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4>No hay temas creados en esta categoría</h4>
                @endif
            </div>




        </div>
    </div>






    @include('layouts.inc.frontfooter')
@endsection
