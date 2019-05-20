<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex,nofollow">
    <title>賃貸検索デモ@hasSection('title') - @yield('title') @endif</title>
    <link rel="stylesheet" href="{{ asset(mix('/css/app.css')) }}">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-dark bg-secondary">
            <a class="navbar-brand" href="{{ route('home') }}">賃貸検索</a>
        </nav>

        @yield('content')

        <footer>
            <div class="container-fluid py-4 bg-secondary">
                <div class="row">

                </div>
            </div>
        </footer>
    </div>
    <script src="{{ asset(mix('js/manifest.js')) }}"></script>
    <script src="{{ asset(mix('js/vendor.js')) }}"></script>
    <script src="{{ asset(mix('js/app.js')) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.6/holder.js"></script>
</body>

</html>
