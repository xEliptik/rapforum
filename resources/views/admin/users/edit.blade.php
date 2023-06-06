@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles de usuario</h4>
                        <hr>

                    </div>
                    <div class="card-body">
                        <form action="{{ url('update-user/' . $user->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">

                                <div class="col-md-4">
                                    <label for="">Nombre</label>
                                    <div class="p-2 border">
                                        <input class="border-0 w-100" value="{{ $user->name }}" name="name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Email</label>
                                    <div class="p-2 border">
                                        <input class="border-0 w-100" type="email" value=" {{ $user->email }}"
                                            name="email">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Usuario</label>
                                    <div class="p-2 border">
                                        <input class="border-0 w-100" value="{{ $user->username }}" name="username">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <label for="">Rol (1 = administrador)</label>
                                    <div class="p-2">
                                        <input type="checkbox" {{ $user->role_as == '1' ? 'checked' : '' }} name="role_as">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                     <label for="">Imagen de perfil:</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                            </div>
                            @if ($user->image && $user->image != 'person.png')
                                <div class="col-md-4">
                                    <br>
                                    <img src="{{ asset('assets/uploads/user/' . $user->image) }}" class="cate-image">
                                    <br>
                                </div>
                            @endif
                            <div class="">
                                <a href="{{ url('users') }}" class="btn btn-primary">Volver</a>

                                <button type="submit" class="btn btn-success">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
