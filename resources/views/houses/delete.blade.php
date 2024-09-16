@extends('layouts.app', ['pageTitle' => 'Delete House'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="text-center">
                <h1 class="text-danger m-0">Delete {{ $house->name }}?</h1>
                <p>in <a href="{{ route('rentals.show', ['rentalUuid' => $rental->uuid]) }}" class="text-decoration-none">{{ $rental->name }}</a>, {{ $rental->location }}</p>
            </div>
            <p>{{ $house->name }} is being rented for KSH {{ number_format($house->rent) }}</p>
            <form role="form" method="POST" action="{{ route('rentals.houses.destroy', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid]) }}">
                @csrf
                @method('DELETE')
                <div class="form-footer">
                    <button type="submit" class="btn btn-danger w-100">Delete House</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
