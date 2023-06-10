<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title')
    </title>
    <!-- CSS Files -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="{{ secure_asset('frontend/css/custom.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('frontend/css/bootstrap5.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('frontend/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ secure_asset('frontend/css/owl.theme.default.min.css') }}" rel="stylesheet">
    <link rel="icon" href="../assets/logo/image.png">
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
</head>

<body class="">
    @include('layouts.inc.frontnavbar')
    @include('layouts.inc.frontnavbar2')


    <div class="content">

        @yield('content')
    </div>

    <script src="{{ secure_asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ secure_asset('frontend/js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ secure_asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        var availableTags = [];
        $.ajax({
            method: "GET",
            url: "/section-list",
            success: function(response) {
                startAutoComplete(response);
            }
        });

        function startAutoComplete(availableTags) {
            $("#search_section").autocomplete({
                source: function(request, response) {
                    var results = $.ui.autocomplete.filter(availableTags, request.term);
                    response(results.slice(0, 6));
                }
            });
        }

        var availableTags2 = [];
        $.ajax({
            method: "GET",
            url: "/forum-list",
            success: function(response) {
                startAutoComplete2(response);
            }
        });

        function startAutoComplete2(availableTags2) {
            $("#search_forum").autocomplete({
                source: function(request, response) {
                    var results = $.ui.autocomplete.filter(availableTags2, request.term);
                    response(results.slice(0, 6));
                }
            });
        }
    </script>
    <script>
        let previousTitle = document.title
    </script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @if (session('status'))
        <script>
            swal(" {{ session('status') }} ");
        </script>
    @endif
    <script></script>
    @yield('scripts')
</body>

</html>
