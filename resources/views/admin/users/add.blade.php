@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>
                Add User
            </h4>
        </div>
        <div class="card-body">User
            <form action="{{ url('insert-user') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Usuario</label>
                        <textarea type="text"  name="username" class="form-control"></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Email</label>
                        <textarea type="email" name="email" class="form-control"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Contraseña</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">Confirmar Contraseña</label>
                        <input type="password" name="password1" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="">Rol (1: Admin, 0: User)</label>
                        <input type="checkbox" name="role_as">
                    </div>

                    <div class="col-md-12">
                        <input type="file" class="form-control" name="image">
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
