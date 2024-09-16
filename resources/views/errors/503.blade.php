@extends('layouts.app', ['pageTitle' => 'Error 503 - ' . config('app.name')])

@section('content')
<section>
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center">
            <div class="col-8 col-md-6 col-lg-7 offset-md-1 order-md-2">
                <img src="{{ asset('assets/img/illustrations/illustration-1.png') }}" alt="Error 404" class="img-fluid">
            </div>
            <div class="col-12 col-md-5 col-lg-4 order-md-1">
                <h1 class="display-3 fw-bold text-center">
                    Error 503
                </h1>
                <p class="mb-5 text-center text-muted">
                    Service unavailable.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
