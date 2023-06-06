@extends('layouts.front')

@section('title')
    categorías
@endsection

@section('content')
    <header class="py-5">

        <div class="container px-lg-5">
            <h2 class="text-center titlepage">Categorías</h2>
            <hr>
            <div class="p-lg-2 rounded-3 text-center loginbackground">
                <div class="m-4 m-lg-5">
                    <h3 class="fw-bold m-lg-5">Visita la mejor cancion, el mejor album y el artista del momento:</h3>
                    <div class="d-flex justify-content-center">
                        @foreach ($sectionstrending as $sec)
                            <div class="ms-4">
                                <a href="{{ url('category/' . $sec->category->name . '/' . $sec->name) }}">
                                    <img src="{{ asset('assets/uploads/section/' . $sec->cate_id . '/' . $sec->position . '.jpg') }}"
                                        class="img-fluid mb-4" alt="assets/uploads/forum/noimage.png"
                                        style="max-width: 300px; height: 300px; border-radius: 5px;">
                                </a>
                                <a style="height: 70px;"
                                    href="{{ url('category/' . $sec->category->name . '/' . $sec->name) }}"
                                    class="titlepage">
                                    @if ($sec->cate_id == 3)
                                        {{ $sec->small_description }}
                                    @else
                                        {{ $sec->name }}
                                    @endif
                                </a>
                                <h3>#1 en {{ $sec->category->name }}</h3>

                            </div>
                        @endforeach
                    </div>

                </div>

            </div>
        </div>

    </header>
    <!-- Page Content-->
    <section class="pt-4">
        <div class="container px-lg-5">
            <!-- Page Features-->

            <div class="row gx-lg-5">

                @foreach ($category as $cate)
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card loginbackground border-0 h-100">
                            <div class="card-body text-center p-4 p-lg-5 pt-0 pt-lg-0">
                                <div class="feature btn-custom bg-gradient text-white rounded-3 mb-4 mt-n4"><img
                                        src="{{ asset('assets/uploads/category/' . $cate->image) }}"
                                        alt="{{ $cate->name }}" class="card-img-top img-fluid"
                                        style="height: 40px; width: 40px;"></div>
                                <h1 class="fs-4 fw-bold">{{ $cate->name }}</h1>
                                <p class="mb-0">{{ $cate->description }}</p>

                            </div>
                            <a href="{{ url('category/' . $cate->name) }}"
                                class="card-title mb-3 ablack text-center btn-grad p-2 mx-2">Visitar</a>


                        </div>
                    </div>
                @endforeach
            </div>
        @endsection
