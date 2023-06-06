    <header class="whitebackground py-5">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center my-5">
                        <h1 class="display-5 fw-bolder text-black mb-2">Participa y opina en los diferentes temas del
                            foro</h1>
                        <p class="lead text-white-50 mb-4">Descubre y debate los temas más emocionantes del rap en The
                            Rap Room.</p>
                        <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                            <a class="btn btn-outline-light btn-lg px-4" href="{{ url('forum/') }}">Visitar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <section>
        <div class="container px-5 my-5 px-5">
            <div class="text-center mb-5">
                <h1 class="fw-bolder">Comentarios destacados del foro</h1>
            </div>
            <div class="row gx-5 justify-content-center">
                @php
                    $commentsChunks = $comments->chunk(2);
                @endphp
                @foreach ($commentsChunks as $chunk)
                    <div class="row gx-5">
                        @foreach ($chunk as $item)
                            <div class="col-lg-6">
                                <!-- Testimonial -->
                                <div class="card mb-4 loginbackground">
                                    <div class="card-body p-4" style="height: 200px;">
                                        <a class="ablack float-end">{{ $item->created_at->format('d/m/Y') }}</a>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0"><i class="bi bi-chat-right-quote-fill fs-1"></i>
                                            </div>
                                            <div class="ms-4">
                                                <a href="{{ url('forum/' . $item->forum->id) }}" class="mb-1 ablack"
                                                    style="font-size: 20px;">{{ $item->forum->title }}</a>
                                                <div class="content-wrapper">
                                                    <!-- Contenedor adicional -->
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('assets/uploads/user/' . $item->user->image) }}"
                                                            alt="{{ $item->user->name }} profile image"
                                                            style="width:20px; height:20px;"
                                                            class="rounded-circle me-2">
                                                        <div class="small">{{ $item->user->username }}</div>
                                                    </div>
                                                    <p class="mt-1">{{ $item->comment }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>
