@extends('layouts.app', ['pageTitle' => 'My Rentals'])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <p class="text-end">
                <a href="{{ route('rentals.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Add Rental
                </a>
            </p>
            <h1>My Rentals</h1>
            @if(count($rentals))
                <div class="row row-cols-1 row-cols-md-2 g-5">
                    @foreach($rentals as $rental)
                        <div class="col">
                            <div class="card border border-primary">
                                <div class="card-body pb-0">
                                    <h2 class="card-title m-0">
                                        {{ $rental->name }}
                                    </h2>
                                    <p class="card-text">
                                        <i class="fa-solid fa-location-dot"></i>
                                        {{ $rental->location }}
                                    </p>
                                    <p class="card-text">
                                        {{ $rental->houses()->count() }} Houses
                                        |
                                        {{ $rental->houses()->where('is_vacant', false)->count() }} Tenants
                                        |
                                        {{ $rental->invoiceItems()->count() }} Invoice Items
                                    </p>
                                    <p class="card-text">
                                        Tenants will be invoiced every {{ str_ordinal($rental->rent_due_day) }} day of the month.
                                    </p>
                                </div>
                                <div class="card-footer text-end">
                                    @if (!$rental->houses()->count())
                                        <a href="{{ route('rentals.delete', ['rentalUuid' => $rental->uuid]) }}" class="card-link text-danger" title="Delete {{ $rental->name }}"><i class="fa-solid fa-trash"></i></a>
                                    @endif
                                    <a href="{{ route('rentals.edit', ['rentalUuid' => $rental->uuid]) }}" class="card-link" title="Edit {{ $rental->name }}"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="{{ route('rentals.invoiceItems.index', ['rentalUuid' => $rental->uuid]) }}" class="card-link">Invoice Items</a>
                                    <a href="{{ route('rentals.show', ['rentalUuid' => $rental->uuid]) }}" class="card-link">View Houses</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h3 class="text-center my-10">You have not added any rental.</h3>
            @endif
        </div>
    </div>
</div>
@endsection
