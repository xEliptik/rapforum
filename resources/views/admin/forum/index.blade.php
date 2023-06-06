@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>category page</h4>
            <hr>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Categoria</th>
                        <th>Usuario</th>
                        <th>Titulo</th>
                        <th>Descripcion</th>
                        <th>Likes</th>
                        <th>Dislikes</th>
                        <th>Imagen</th>
                        <th>Botones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($forum as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ count($item->likes) }}</td>
                            <td>{{ count($item->dislikes) }}</td>
                            <td>
                                <img src="{{ asset('assets/uploads/forum/' . $item->image) }}" class="cate-image"
                                    alt="Image here">
                            </td>
                            <td>
                                <a href="{{ url('forum-admin/' . $item->id) }}" class='btn btn-primary'>Ver</a>
                                <a href="{{ url('delete-forum-admin/' . $item->id) }}" class='btn btn-danger'>Borrar</a>
                            </td>
                        </tr>
                    @endforeach



                </tbody>
            </table>
        </div>
    </div>
@endsection
