@extends('layouts.app', ['pageTitle' => config('app.name') . ' - Online Rental Management System'])

@section('content')
<section data-jarallax data-speed=".8" class="pt-10 pt-md-14 pb-12 pb-md-15 overlay overlay-primary overlay-80 jarallax" style="background-image: url({{ asset('assets/img/covers/cover-6.jpg') }});">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 text-center">
                <h1 class="display-1 fw-bold text-white mb-6 mt-n3">
                    Easily manage your rental properties
                </h1>
                <a class="btn btn-pill btn-white shadow lift" href="{{ route('register') }}">
                    Get Started for Free
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
