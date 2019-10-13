<!DOCTYPE html>
<html class="bg-gray-200 {{ auth()->check() ? 'logged-in' : 'logged-out' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <link rel="icon" href="/images/favicon.ico" type="image/x-icon" />
        <link href="{{ mix('/css/main.css') }}" rel="stylesheet">
        <script src="{{ mix('/js/main.js') }}" defer></script>
        @routes
    </head>

    <body class="font-lato leading-none text-gray-900 antialiased">
        <div id="app" data-page="{{ json_encode($page) }}">
            <vue-snotify></vue-snotify>
        </div>

    </body>

</html>
