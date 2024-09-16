@extends('layouts.app', ['pageTitle' => 'Pay Invoice'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <a href="{{ route('rentals.houses.tenants.show', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid, 'tenantUuid' => $house->tenant->uuid]) }}" class="text-decoration-none">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Invoices
            </a>
            <div class="text-center">
                <h1 class="m-0">Pay Invoice</h1>
                <p>Invoice number <b>{{ $invoice->invoice_number }}</b></p>
                <p>for {{ $tenant->user->name }} in {{ $house->name }},
                    @can('rentals.index')
                        <a href="{{ route('rentals.show', ['rentalUuid' => $rental->uuid]) }}" class="text-decoration-none">{{ $rental->name }}</a>
                    @else
                        {{ $rental->name }}
                    @endcan
                , {{ $rental->location }}</p>
            </div>
            <form role="form" method="POST" action="{{ route('rentals.houses.tenants.invoices.payments.store', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid, 'tenantUuid' => $tenant->uuid, 'invoiceUuid' => $invoice->uuid]) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Amount in KSH</label>
                    <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ (old('amount')) ? old('amount') : $invoice->total }}" placeholder="Amount in KSH" readonly>
                    @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Pay From</label>
                    <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ (old('phone')) ? old('phone') : $tenant->phone }}" placeholder="Phone" readonly>
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Pay Invoice</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
