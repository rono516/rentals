@extends('layouts.app', ['pageTitle' => 'My Houses in ' . $rental->name . ', ' . $rental->location . ' - ' . config('app.name')])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="m-0">Houses in {{ $rental->name }}, {{ $rental->location }}</h1>
            <p>
                @can('invoiceItems.index')
                    <a href="{{ route('rentals.invoiceItems.index', ['rentalUuid' => $rental->uuid]) }}" class="text-decoration-none" title="Invoice items set for {{ $rental->name }}">
                        {{ arr_natural_language($invoiceItems) }}
                    </a>
                @else
                    {{ arr_natural_language($invoiceItems) }}
                @endcan

                will be invoiced every {{ str_ordinal($rental->rent_due_day) }} day of the month.
            </p>

            @can('houses.create')
                <p>
                    <a href="{{ route('rentals.houses.create', ['rentalUuid' => $rental->uuid]) }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i>
                        Add House
                    </a>
                </p>
            @endcan

            @include('houses.index')
        </div>
    </div>
</div>
@endsection
