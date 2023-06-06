@extends('layouts.front')

@section('title')
    {{ str_replace('"', '', $category->name) }}
@endsection

@section('content')
    <div class="py-2 mb-4 shadow-sm">
        <!-- py-3  -->
        <div class="container">
            <a style="color: black;" href="{{ url('category/') }}">
                Categoría /
            </a>
            <a style="color: black;" href="{{ url('category/' . $category->name) }}">
                {{ $category->name }}
            </a>
        </div>
    </div>

    <div class="d-flex justify-content-center align-items-center mb-4">
        <h2 class="titlepage">Las noticias más destacadas del género</h2>
    </div>


    <div class="container px-4 px-lg-5">
        <!-- Heading Row-->
        <div class="row gx-4 gx-lg-5 align-items-center my-5 loginbackground rounded">
            <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0"
                    src="{{ asset('assets/uploads/section/4/title.jpg') }}" style="width: 900px; height: 400px;" /></div>
            <div class="col-lg-5">
                <h1 class="font-weight-light">{{ $section[0]->name }}</h1>
                <p>{{ $section[0]->description }}</p>
                <a class="btn-grad" href="{{ url('category/' . $category->name . '/' . $section[0]->name) }}">Ver
                    noticia</a>
            </div>
        </div>


        <div class="d-flex justify-content-center align-items-center mb-4">
            <h2 class="titlepage">Otras noticias de interés</h2>
        </div>

        <div class="row gx-4 gx-lg-5">
            @foreach ($section as $item)
                @if ($item->position != 0)
                    <div class="col-md-4 mb-5">
                        <div class="card h-100 loginbackground">
                            <div class="card-body">
                                <h2 class="card-title">{{ $item->name }}</h2>
                                <hr>
                                <div class="d-flex align-items-center justify-content-center">
                                    <img style="height: 300px; width: 300px;" class="img-fluid"
                                        src="{{ asset('assets/uploads/section/' . $item->cate_id . '/' . $item->position . '.jpg') }}"
                                        alt="{{ asset('assets/uploads/forum/noimage.png') }}">
                                </div>
                                <p class="card-text mt-4">{{ $item->small_description }}</p>
                            </div>
                            <div class="justify-content-center card-footer text-center">
                                <a class="btn btn-grad btn-sm w-75"
                                    href="{{ url('category/' . $category->name . '/' . $item->name) }}">Ver noticia</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>


    </div>
    @include('layouts.inc.frontfooter')
@endsection
