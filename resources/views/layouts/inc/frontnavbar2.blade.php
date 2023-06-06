<nav class="navbar navbar-expand-lg navbar-dark ">
    <div class="container d-flex justify-content-between">
        <div class="search-bar mx-auto">
            <!-- aquí se añade la clase mx-auto -->
            <form action="{{ url('searchsection') }}" method="POST">
                @csrf
                <div class="input-group mb-4" style="width: 100%; margin-top:-3%">
                    <input type="search" class="form-control custom-searchbar" id="search_section" placeholder="Buscar"
                        aria-label="Buscar" aria-describedby="basic-addon1" name="section_name">
                    <button type="submit" class="input-group-text custom-search"><i
                            class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
</nav>
