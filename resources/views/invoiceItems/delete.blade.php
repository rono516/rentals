@extends('layouts.app', ['pageTitle' => 'Delete Invoice Item'])

@section('content')
<div class="container">
    <div class="row justify-content-center my-10">
        <div class="col-12 col-md-6">
            <div class="text-center">
                <h1 class="text-danger m-0">Delete {{ $invoiceItem->name }} Invoice Item?</h1>
                <p>for <a href="{{ route('rentals.show', ['rentalUuid' => $rental->uuid]) }}" class="text-decoration-none">{{ $rental->name }}</a>, {{ $rental->location }}</p>
            </div>
            <form role="form" method="POST" action="{{ route('rentals.invoiceItems.destroy', ['rentalUuid' => $rental->uuid, 'invoiceItemUuid' => $invoiceItem->uuid]) }}">
                @csrf
                @method('DELETE')
                <div class="form-footer">
                    <button type="submit" class="btn btn-danger w-100">Delete Invoice Item</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
