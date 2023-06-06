@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>
                Efit Section
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ url('update-section/' . $sections->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <label for="name">Category</label>
                    <select class="form-select" name="cate_id" id="">
                        @foreach ($category as $cat)
                            <option value="{{ $cat->id }}" {{ $sections->cate_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <div class="col-md-6 mb-3">
                        <label for="">Name</label>
                        <input type="text" class="form-control" value=" {{ $sections->name }} " name="name">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Description</label>
                        <textarea type="text" rows='3' name="description" class="form-control">{{ $sections->description }}</textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Small Description</label>
                        <textarea type="text" rows='3' class="form-control" name="small_description">{{ $sections->small_description }}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Status</label>
                        <input type="checkbox" {{ $sections->status == '1' ? 'checked' : '' }} name="status">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Trending</label>
                        <input type="checkbox" {{ $sections->trending == '1' ? 'checked' : '' }} name="trending">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Meta Title</label>
                        <input type="text" class="form-control" value=" {{ $sections->meta_title }}" name="meta_title">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Meta Keywords</label>
                        <input type="text" value="{{ $sections->meta_keywords }}" name="meta_keywords"
                            class="form-control"></input>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Meta Description</label>
                        <input type="text" value="{{ $sections->meta_description }}" name="meta_description"
                            class="form-control"></input>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Position</label>
                        <input type="number" value="{{ $sections->position }}" name="position"
                            class="form-control"></input>
                    </div>
                    @if ($sections->image)
                        <img src="{{ asset('assets/uploads/section/' . '/' . $sections->cate_id . '/' . $sections->image) }}"
                            alt="">
                    @endif
                    <div class="col-md-12">
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
