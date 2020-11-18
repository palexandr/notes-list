<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'My notes') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">  
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div id="app"></div>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>