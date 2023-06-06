@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>category page</h4>
            <hr>
        </div>
        <div class="card-body">
            <a class='btn btn-success' href="{{ url('forum-admin') }}">Volver</a>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Usuario</th>
                        <th>Tema</th>
                        <th>Comentario</th>
                        <th>Likes</th>
                        <th>Dislikes</th>
                        <th>Botones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($comments as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->forum->title }}</td>
                            <td>{{ $item->comment }}</td>
                            <td>{{ count($item->likes) }}</td>
                            <td>{{ count($item->dislikes)}}</td>
                            <td>
                                <a href="{{ url('delete-forum-admin/' . $forum->id . '/' . $item->id) }}"
                                    class='btn btn-danger'>Borrar</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
