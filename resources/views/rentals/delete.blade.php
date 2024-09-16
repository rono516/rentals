@extends('layouts.app', ['pageTitle' => 'Delete Rental'])

@section('content')
<div class="container">
    <div class="row justify-content-center my-10">
        <div class="col-12 col-md-6">
            <h1 class="text-danger">Delete Rental?</h1>
            <p>{{ $rental->name }} located in {{ $rental->location }}</p>
            <form role="form" method="POST" action="{{ route('rentals.destroy', ['rentalUuid' => $rental->uuid]) }}">
                @csrf
                @method('DELETE')
                <div class="form-footer">
                    <button type="submit" class="btn btn-danger w-100">Delete Rental</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
