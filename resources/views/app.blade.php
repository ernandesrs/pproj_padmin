<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
    <link href="{{ asset('css/auth/app.css') }}" rel="stylesheet" />
    @routes
    <script src="{{ asset('/js/inertia/app.js') }}" defer></script>
    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>
