@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles de Videoclip</h4>
                        <hr>

                    </div>
                    <div class="card-body">
                        <form action="{{ url('update-videoclip/' . $videoclip->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row">

                                <div class="col-md-4">
                                    <label for="">Cancion</label>
                                    <div class="p-2 border">
                                        <input class="border-0 w-100" value="{{ $videoclip->song }}" name="song">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Artista</label>
                                    <div class="p-2 border">
                                        <input class="border-0 w-100" type="text" value=" {{ $videoclip->singer }}"
                                            name="singer">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Descripcion</label>
                                    <div class="p-2 border">
                                        <input class="border-0 w-100" value="{{ $videoclip->description }}"
                                            name="description">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="">Premio</label>
                                    <div class="p-2">
                                        <input type="checkbox" {{ $videoclip->award == '1' ? 'checked' : '' }}
                                            name="award">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <input type="file" name="image" class="form-control">
                                </div>
                            </div>
                            @if ($videoclip->image && $videoclip->image != 'person.png')
                                <div class="col-md-4">
                                    <br>
                                    <img src="{{ asset('assets/uploads/videoclip/' . $videoclip->image) }}"
                                        class="cate-image">
                                    <br>
                                </div>
                            @endif
                            <div class="">
                                <a href="{{ url('videoclips') }}" class="btn btn-primary">Volver</a>

                                <button type="submit" class="btn btn-success">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
