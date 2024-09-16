<h1 class="mt-5">Invoices</h1>
@if ($tenant->invoices()->count())
    <p>
        <a href="{{ route('rentals.houses.tenants.show', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid, 'tenantUuid' => $house->tenant->uuid]) }}" class="btn btn-primary btn-xs">
            <i class="fa-solid fa-arrows-rotate"></i>
            Sync Payments
        </a>
    </p>
    <table class="table" id="datatable">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Invoice Number</th>
                <th scope="col">Invoiced On</th>
                <th scope="col">Total</th>
                <th scope="col">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $index => $invoice)
                <tr>
                    <th scope="row">{{ ++$index }}</th>
                    <td>
                        <a href="{{ route('rentals.houses.tenants.invoices.show', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid, 'tenantUuid' => $tenant->uuid, 'invoiceUuid' => $invoice->uuid]) }}" class="text-decoration-none" title="View Invoice">
                            {{ $invoice->invoice_number }}
                        </a>
                    </td>
                    <td title="{{ $invoice->created_at->diffForHumans() }}">{{ $invoice->created_at->format('d/m/Y') }}</td>
                    <td>KSH {{ number_format($invoice->total) }}</td>
                    <td>
                        @if ($invoice->paid_at)
                            <span class="success">Paid {{ $invoice->paid_at->diffForHumans() }}</span>
                        @else
                            <a href="{{ route('rentals.houses.tenants.invoices.payments.create', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid, 'tenantUuid' => $tenant->uuid, 'invoiceUuid' => $invoice->uuid]) }}" class="text-decoration-none">Make Payment</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h3 class="text-center my-10">No invoices available.</h3>
@endif
