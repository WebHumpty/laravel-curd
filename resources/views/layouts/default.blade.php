<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DEMO-SITE</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div id="app">
    <app></app>
    <div>
        <router-view></router-view>
    </div>
</div>
<hr class="mt-5">
<footer>
    <div class="container pt-5 pb-5">
        <div class="row">
            <div class="col-md-12">
                <p>© DEMO-SITE</p>
            </div>
        </div>
    </div>
</footer>
</body>
<script src="{{ asset('js/app.js') }}"></script>
</html>