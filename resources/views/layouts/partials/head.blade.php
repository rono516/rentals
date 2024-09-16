<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ isset($pageTitle) ? $pageTitle : config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/favicon/favicon.ico') }}" type="image/x-icon" />
    <link rel="stylesheet" href="{{ asset('assets/css/libs.bundle.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/theme.bundle.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <script src="https://kit.fontawesome.com/84e6af0da9.js" crossorigin="anonymous"></script>
</head>
