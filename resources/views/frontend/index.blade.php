@extends('layouts.front')

@section('title')
    The Rap Room
@endsection

@section('content')
    @include('layouts.inc.homecontent')

    <div class="py-5 mt-4">
        <div class="container ">

            <h2>Secciones populares</h2>
            <div class="row">
                <div class="owl-carousel featured-carousel owl-theme">
                    @foreach ($featured_sections as $item)
                        <div class="item">
                            <div class="card loginbackground">
                                <div class="card-img-container ">
                                    <img src="{{ asset('assets/uploads/section/' . $item->cate_id . '/' . $item->position . '.jpg') }}"
                                        alt="{{ $item->name }}" class="card-img">
                                </div>
                                <div class="card-body ">
                                    <h5 class="card-title text-center">{{ Illuminate\Support\Str::limit($item->name, 20) }}
                                    </h5>
                                    <div class="d-flex justify-content-center">
                                        <a class="btn btn-grad btn-sm w-75 mx-auto"
                                            href="{{ url('category/' . $item->category->name . '/' . $item->name) }}">Visitar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    {{--
    <div class="py-5">
        <div class="container">
            <h2> Trending Category</h2>
            <div class="row">
                <div class="owl-carousel featured-carousel owl-theme">
                    @foreach ($trending_category as $tcategory)
                        <div class="item">
                            <a href="{{ url('category/' . $tcategory->name) }}">
                                <div class="card">
                                    <img src=" {{ asset('assets/uploads/category/' . $tcategory->image) }} "
                                        alt="Section img">
                                    <div class="card-body">
                                        <h5>{{ $tcategory->name }} </h5>
                                        <span> {{ $tcategory->description }} </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
--}}

    @include('layouts.inc.frontfooter')
@endsection


@section('scripts')
    <script>
        $('.featured-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            dots: false,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }
        })
    </script>
@endsection
