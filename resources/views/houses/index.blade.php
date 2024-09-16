@if(count($houses))
    <div class="row row-cols-1 row-cols-md-2 g-5">
        @foreach($houses as $house)
            <div class="col">
                <div class="card border border-secondary">
                    <div class="card-body pb-0">
                        <h2 class="card-title m-0">
                            {{ $house->name }}
                        </h2>
                        <p class="card-text">
                            being rented at KSH {{ number_format($house->rent) }} per month
                            @if (!$house->is_vacant)
                                <br>
                                by
                                <a href="{{ route('rentals.houses.tenants.show', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid, 'tenantUuid' => $house->tenant->uuid]) }}" class="text-decoration-none">
                                    {{ $house->tenant->user->name }}
                                </a>
                                <br>
                                @if ($house->tenant->invoices()->count())
                                - {{ $house->tenant->invoices()->count() }} invoices
                                @endif

                                @if ($house->tenant->invoices()->whereNull('paid_at')->count())
                                    <span class="text-danger">({{ $house->tenant->invoices()->whereNull('paid_at')->count() }} unpaid)</span>
                                @endif
                            @endif
                        </p>
                    </div>
                    <div class="card-footer text-end">
                        @if ($house->is_vacant)
                            <a href="{{ route('rentals.houses.delete', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid]) }}" class="card-link text-danger" title="Delete {{ $house->name }}">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        @endif

                        @can('houses.edit')
                            <a href="{{ route('rentals.houses.edit', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid]) }}" class="card-link" title="Edit {{ $house->name }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        @endcan

                        @if ($house->is_vacant)
                            <a href="{{ route('rentals.houses.tenants.create', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid]) }}" class="card-link">Add Tenant</a>
                        @else
                            @can('houses.vacate')
                                <a href="{{ route('rentals.houses.vacate', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid]) }}" class="card-link text-danger" title="Vacate {{ $house->name }}">Vacate House</a>
                            @endcan
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <h3 class="text-center my-10">You have not added any houses to {{ $rental->name }}.</h3>
@endif
