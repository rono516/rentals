@extends('layouts.app', ['pageTitle' => 'Dashboard'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="mt-10">Welcome, {{ auth()->user()->name }}</h1>
        </div>
    </div>
</div>
@endsection
