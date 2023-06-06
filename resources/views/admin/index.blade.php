@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>Bienvenido {{ Auth::user()->name }}</h1>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-warning card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">content_copy</i>
                            </div>
                            <h2 style="color: #3c4858; text-align: start">Categorías</h2>
                            <h1 class="card-title" style="text-align: center;">{{ $users }}</h1>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="{{ url('/categories') }}">Ver categorías</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-success card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">content_copy</i>
                            </div>
                            <h2 style="color: #3c4858; text-align: start"">Elementos</h2>
                            <h1 class="card-title" style="text-align: center;">{{ $sections }}</h1>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="{{ url('/sections') }}">Ver elementos</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-danger card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">content_copy</i>
                            </div>
                            <h2 style="color: #3c4858; text-align: start"">Usuarios</h2>
                            <h1 class="card-title" style="text-align: center;">{{ $users }}</h1>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="{{ url('/users') }}">Ver usuarios</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">content_copy</i>
                            </div>
                            <h2 style="color: #3c4858; text-align: start">Temas Foro:</h2>
                            <h1 class="card-title" style="text-align: center;">{{ $forum }}</h1>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="{{ url('/forum-admin') }}">Ver Temas en el foro</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header card-header-info card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">content_copy</i>
                            </div>
                            <h2 style="color: #3c4858; text-align: start">Videoclips:</h2>
                            <h1 class="card-title" style="text-align: center;">{{ $videoclip }}</h1>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <a href="{{ url('/forum-videoclips') }}">Ver videoclips</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
