@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Sections page</h4>
            <hr>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Small Description</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Trending</th>
                        <th>Meta Ttitle</th>
                        <th>Meta Keywords</th>
                        <th>Meta Description</th>
                        <th>Position</th>
                        <th>Image</th>
                        <th>Botones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sections as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->small_description }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->trending }}</td>
                        <td>{{ $item->meta_title }}</td>
                        <td>{{ $item->meta_keywords }}</td>
                        <td>{{ $item->meta_description }}</td>
                        <td>{{ $item->position }}</td>
                        
                        <td>
                            <img src="{{ asset('assets/uploads/section/' . $item->cate_id . '/' . $item->position . '.jpg') }}" class="cate-image" alt="Image here">
                        </td>
                        <td>
                            <a href="{{ url('edit-section/'.$item->id) }}" class='btn btn-primary btn-sm''>Editar</a>
                            <a href="{{ url('delete-section/'.$item->id) }}" class='btn btn-danger btn-sm'>Borrar</a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
