<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col" id="app">
                    <repository-list></repository-list>
                </div>
            </div>
        </div>
        <script src="{{ mix('/js/app.js') }}"></script>
   </body>
</html>
