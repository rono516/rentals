@extends('layouts.app', ['pageTitle' => 'Vacate House'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="text-center">
                <h1 class="m-0">Vacate {{ $house->name }}</h1>
                <p>in <a href="{{ route('rentals.show', ['rentalUuid' => $rental->uuid]) }}" class="text-decoration-none">{{ $rental->name }}</a>, {{ $rental->location }}</p>
            </div>
            <h5>Current Tenant</h5>
            @include('tenants.partials.tenant')
            <p class="text-danger text-center">This will delete the current tenant. This action CANNOT be undone.</p>
            <form role="form" method="POST" action="{{ route('rentals.houses.vacateStore', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid]) }}">
                @csrf
                <div class="form-footer">
                    <button type="submit" class="btn btn-danger w-100">Vacate House</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
