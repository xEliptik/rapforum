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
        <h2 class="titlepage">Los {{ $cantidad }} mejores {{ $category->name }} del género</h2>
    </div>


    <div class="container">
        <div class="card shadow">
            <div class="card-body listbakcground">
                <div class="row">
                    <div class="col-md-12 ">
                        @if (count($section) > 0)
                            <!-- Sección para el primer elemento -->


                            @if ($category->id == 3)
                                <a href="https://open.spotify.com/search/{{ $section[0]->small_description }}"
                                    target="_blank" class="float-end">
                                    <img style="height: 40px" src="{{ url('assets/logo/spotify.png') }}">
                                </a>
                            @else
                                <a href="https://open.spotify.com/search/{{ $section[0]->name }}" target="_blank"
                                    class="float-end">
                                    <img style="height: 40px" src="{{ url('assets/logo/spotify.png') }}">
                                </a>
                            @endif

                            <div class="d-flex justify-content-center align-items-center">
                                <div class="d-flex justify-content-center align-items-center">
                                    <p class="first-place ">1</p>
                                    <div class="col-md-5 text-center">
                                        <img src="{{ asset('assets/uploads/section/' . $section[0]->cate_id . '/' . $section[0]->position . '.jpg') }}"
                                            alt="{{ $section[0]->name }}" width="280" class="img-fluid">
                                    </div>
                                    <div class="col-md-7 d-flex flex-column justify-content-center">
                                        <div class="text-center align-items-center" style="width: 650px">
                                            @if ($category->id != 3)
                                                <h3><a class="ablack titlepage" style="width: 650px"
                                                        href="{{ url('category/' . $category->name . '/' . $section[0]->name) }}">{{ $section[0]->name }}</a>
                                                </h3>
                                            @endif
                                            <a href="{{ url('category/' . $category->name . '/' . $section[0]->name) }}"
                                                class="titlepage" style="width: 650px">{{ $section[0]->small_description }}
                                            </a>
                                            <hr>
                                            <p>{{ $section[0]->meta_description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <!-- Lista de elementos restantes -->
                            <table id="sectionTable" class="table table-striped listbakcground table-sortable">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th data-sortable="true">Position</th>
                                        <th data-sortable="true">Nombre</th>
                                        @if ($category->id != 3)
                                            <th data-sortable="true">Artista</th>
                                        @endif
                                        <th data-sortable="true">Semana Pasada</th>
                                        <th data-sortable="true">Mejor posición</th>
                                        <th data-sortable="true">Semanas en el top</th>
                                        <th>Enlace</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($section as $key => $item)
                                        @if ($key > 0)
                                            <tr>
                                                <td><img src="{{ asset('assets/uploads/section/' . $item->cate_id . '/' . $item->position . '.jpg') }}"
                                                        alt="{{ $item->name }}" width="180"></td>
                                                <td>{{ $item->position }}</td>
                                                @if ($category->id != 3)
                                                    <td><a class="ablack"
                                                            href="{{ url('category/' . $category->name . '/' . $item->name) }}">{{ $item->name }}</a>
                                                    </td>
                                                @endif
                                                <td><a class="ablack"
                                                        @if ($category->id == 3) href="{{ url('category/' . $category->name . '/' . $item->name) }}" @endif>
                                                        {{ $item->small_description }}</a>
                                                </td>
                                                <td>{{ $item->meta_title }}</td>
                                                <td>{{ $item->meta_keywords }}</td>
                                                <td>{{ $item->meta_description }}</td>
                                                @if ($category->id == 3)
                                                    <td><a href="https://open.spotify.com/search/{{ $item->small_description }}"
                                                            target="_blank"><img style="height: 40px"
                                                                src="{{ url('assets/logo/spotify.png') }}"></a>
                                                    </td>
                                            </tr>
                                        @else
                                            <td><a href="https://open.spotify.com/search/{{ $item->name }}"
                                                    target="_blank"><img style="height: 40px"
                                                        src="{{ url('assets/logo/spotify.png') }}"></a></td>
                                            </tr>
                                        @endif
                                    @endif
                        @endforeach
                        </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.inc.frontfooter')
    <script src="{{ asset('frontend/js/tablesort.js') }}"></script>
@endsection
