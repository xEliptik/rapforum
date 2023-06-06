@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Videoclip page</h4>
            <hr>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Song</th>
                        <th>Singer</th>
                        <th>Description</th>
                        <th>Views</th>
                        <th>Award</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($videoclip as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->song }}</td>
                            <td>{{ $item->singer }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->views }}</td>
                            <td>{{ $item->award }}</td>
                            <td>
                                <img src="{{ asset('assets/uploads/videoclip/' . $item->image) }}" class="cate-image"
                                    alt="Image here">
                            </td>
                            <td>
                                <a href="{{ url('edit-videoclip/' . $item->id) }}" class='btn btn-primary'>Editar</a>
                                <a href="{{ url('delete-videoclip/' . $item->id) }}" class='btn btn-danger'>Borrar</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
