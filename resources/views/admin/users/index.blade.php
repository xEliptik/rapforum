@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Usuarios Registrados</h4>
            <hr>
            <a href="{{ url('add-user') }}" class='btn btn-info btn-sm'>Crear nuevo usuario</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Imagen</th>
                        <th>Rol</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Cuenta Google</th>
                        <th>Botones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $item)
                        <tr>
                            <td>{{ $item->id }}</td>

                            <td>
                                @if ($item->image)
                                    <img class="cate-image" src="{{ asset('assets/uploads/user/' . $item->image) }}"
                                        alt="">
                                @else
                                    No hay imagen
                                @endif

                            </td>
                            <td>{{ $item->role_as == '0' ? 'Usuario' : 'Administrador' }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->username }}</td>
                            <td>@if ($item->google_id) Sí @else No @endif </td>


                            <td class="text-center">
                                <a href="{{ url('edit-user/' . $item->id) }}" class='btn btn-primary btn-sm'>Editar</a>
                                <a href="{{ url('delete-user/' . $item->id) }}" class='btn btn-danger btn-sm'>Borrar</a>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
@endsection
