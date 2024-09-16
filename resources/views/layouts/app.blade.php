<!doctype html>
<html lang="en" class="h-100">
    @include('layouts.partials.head')
    <body class="d-flex flex-column h-100">
        @include('layouts.partials.nav')
        <main class="mb-5">
            @yield('content')
        </main>
        @include('layouts.partials.footer')
        @include('layouts.partials.scripts')
    </body>
</html>
