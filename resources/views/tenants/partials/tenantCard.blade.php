<div class="card border border-primary">
    <div class="card-body pb-0">
        <h1 class="m-0">{{ $tenant->user->name }}</h1>
        <p>in
            @can('rentals.index')
                <a href="{{ route('rentals.show', ['rentalUuid' => $rental->uuid]) }}" class="text-decoration-none">{{ $rental->name }}</a>
            @else
                {{ $rental->name }}
            @endcan
            , {{ $rental->location }}</p>
        @include('tenants.partials.tenant')
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('rentals.houses.tenants.edit', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid, 'tenantUuid' => $house->tenant->uuid]) }}" title="Edit {{ $tenant->user->name }} Details" class="card-link">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>

        @can('invoices.create')
            <a href="{{ route('rentals.houses.tenants.invoices.create', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid, 'tenantUuid' => $house->tenant->uuid]) }}" class="card-link" title="Invoice {{ $house->tenant->user->name }}">Invoice</a>
        @endcan
    </div>
</div>
