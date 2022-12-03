<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
    <link href="{{ asset('css/panel/app.css') }}" rel="stylesheet" />

    @php
        $settings = \App\Models\Content::where('name', 'front_settings')->first();
    @endphp
    @if ($settings && $settings->content->header->favicon ?? null)
        <link rel="shortcut icon" href="{{ Storage::url($settings->content->header->favicon) }}" type="image/x-icon">
    @endif

    @routes
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>
