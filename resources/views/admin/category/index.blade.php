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
                        <th>Name</th>
                        <th>Description</th>
                        <th>Meta_description</th>
                        <th>Meta_title</th>
                        <th>Status</th>
                        <th>Popular</th>
                        <th>Image</th>
                        <th>Botones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->meta_description }}</td>
                        <td>{{ $item->meta_title }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->popular }}</td>
                        <td>
                            <img src="{{ asset('assets/uploads/category/'.$item->image) }}" class="cate-image" alt="Image here">
                        </td>
                        <td>
                            <a href="{{ url('edit-category/'.$item->id) }}" class='btn btn-primary'>Editar</a>
                            <a href="{{ url('delete-category/'.$item->id) }}" class='btn btn-danger'>Borrar</a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    
@endsection
