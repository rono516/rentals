@extends('layouts.app', ['pageTitle' => 'Invoice Tenant'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="text-center">
                <h1 class="m-0">Invoice {{ $house->tenant->user->name }}</h1>
                <p>in <a href="{{ route('rentals.show', ['rentalUuid' => $rental->uuid]) }}" class="text-decoration-none">{{ $rental->name }}</a>, {{ $rental->location }}</p>
            </div>
            <form role="form" method="POST" action="{{ route('rentals.houses.tenants.invoices.store', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid, 'tenantUuid' => $tenant->uuid]) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Invoice Item</label>
                    <select id="invoice_item" class="form-control @error('invoice_item') is-invalid @enderror" name="invoice_item" aria-describedby="invoiceItemHelp">
                        <option value="">Select</option>
                        @foreach ($invoiceItems as $invoiceItem)
                            <option value="{{ $invoiceItem->id }}" {{ (old('invoice_item') == $invoiceItem->id) ? 'selected' : '' }}>
                                {{ $invoiceItem->name }}
                                (KSH {{ ($invoiceItem->required) ? $house->rent : $invoiceItem->amount }})
                            </option>
                        @endforeach
                    </select>
                    <div id="invoiceItemHelp" class="form-text">Missing invoice item? Ensure it has been added to your <a href="{{ route('rentals.invoiceItems.index', ['rentalUuid' => $rental->uuid]) }}" class="text-decoration-none">Invoice Items</a>.</div>
                    @error('invoice_item')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Amount in KSH</label>
                    <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') }}" placeholder="Amount in KSH">
                    @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Invoice Tenant</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
