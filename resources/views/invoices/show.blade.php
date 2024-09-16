@extends('layouts.app', ['pageTitle' => 'Invoice Details'])

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-4">
            @include('tenants.partials.tenantCard')
        </div>
        <div class="col-12 col-md-8">
            <a href="{{ route('rentals.houses.tenants.show', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid, 'tenantUuid' => $house->tenant->uuid]) }}" class="text-decoration-none">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Invoices
            </a>

            <h1>
                Invoice #{{ $invoice->invoice_number }}
                <br>
                of KSH {{ number_format($invoice->total) }} created on {{ $invoice->created_at->format('d/m/Y') }}
            </h1>
            @if ($invoice->payment)
                <p class="text-success">
                    <i class="fa-sharp fa-solid fa-circle-check"></i>
                    Paid on {{ $invoice->payment->created_at->format('d-m-Y') }}
                </p>
            @endif
            <p>Invoice Details</p>
            <table class="table" id="datatable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Invoice Item</th>
                        <th scope="col">Amount Invoiced</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoiceDetails as $index => $invoiceDetail)
                        <tr>
                            <th scope="row">{{ ++$index }}</th>
                            <td>{{ $invoiceDetail->invoiceItem->name }}</td>
                            <td>KSH {{ number_format($invoiceDetail->amount) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
