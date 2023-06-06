@extends('layouts.front')

@section('title')
    Perfil
@endsection

@section('content')
    <div class="py-5">
        <div class="container">
            <div class="row">
                <form action="{{ url('user-update/' . $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mx-md-n5 justify-content-center">
                        <div class="col-md-3 card color-container d-flex flex-column align-items-center">
                            <h2 class="mt-4"><strong>Imagen de perfil</strong></h2>
                            <div style="text-align: center; margin-top: 15%">
                                <img src="{{ asset('assets/uploads/user/' . $user->image) }}"
                                    alt="{{ $user->name }} profile image" style="width:200px; height:200px;">
                            </div>

                            <input type="file" style="width: 300px;" class="mt-3 mb-3 d-flex" id="image"
                                name="image">
                            <label type="hide" id="{{ $user->id }}" name="{{ $user->id }}">
                        </div>

                        <div class="col-md-8 card color-container mx-md-4">
                            <h2 class="mt-4"><strong>Perfil de usuario</strong> </h2>
                            <div class="row mb-3 mt-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name"><strong>Nombre:</strong></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $user->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="username"><strong>Usuario:</strong></label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            value="{{ $user->username }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="password"><strong>Nueva contraseña:</strong></label>
                                        <input type="password" class="form-control" name="newpassword" id="newpassword"
                                            value="">
                                    </div>
                                    <button href="" type="submit" class="btn-grad mt-3 m-0">Guardar cambios</button>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email"><strong>Correo electrónico:</strong></label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $user->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="password"><strong>Contraseña actual:</strong></label>
                                        <input type="password" class="form-control" name="password" id="password"
                                            value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="password"><strong>Repite la nueva contraseña:</strong></label>
                                        <input type="password" class="form-control" name="newpassword2" id="newpassword2"
                                            value="">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="py-5">
        <div class="container">
            <div class="row gx-5 gx-lg-5">
                @if (count($likedSections) > 0)
                    <h2> Secciones valoradas: </h2>
                    @foreach ($likedSections as $section)
                        <div class="col-md-4 mb-5">
                            <div class="card h-100 loginbackground">
                                <div class="card-body">
                                    <h4 class="card-title d-flex align-items-center justify-content-center"
                                        style="height: 55px">{{ $section->name }}</h4>
                                    <h4>{{ $section->stars_rated }}</h4>
                                    <hr>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <img style="height: 200px; width: 200px;" class="img-fluid"
                                            src="{{ asset('assets/uploads/section/' . $section->cate_id . '/' . $section->position . '.jpg') }}"
                                            alt="{{ asset('assets/uploads/section/' . $section->cate_id . '/' . $section->image) }}">
                                    </div>
                                </div>
                                <div class="justify-content-center card-footer text-center">
                                    <a class="btn btn-grad btn-sm w-75"
                                        href="{{ url('category/' . $section->category->name . '/' . $section->name) }}">Ver
                                        Elemento</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h2>No has dado like a ningún elemento.</h2>
                @endif
            </div>
        </div>
    </div>
    @include('layouts.inc.frontfooter')
@endsection
