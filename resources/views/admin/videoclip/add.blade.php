@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>
                Add Videoclip
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ url('insert-videoclip') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="">Song</label>
                        <input type="text" class="form-control" name="song">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Singer</label>
                        <input type="text" class="form-control" name="singer">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="">Description</label>
                        <textarea type="text" rows='3' name="description" class="form-control"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Views</label>
                        <input type="number" class="form-control" name="views">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Award</label>
                        <input type="checkbox" name="award">
                    </div>
                    <div class="col-md-12">
                        <input type="file" class="form-control" name="image">
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" name="image">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
