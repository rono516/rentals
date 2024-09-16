@extends('layouts.app', ['pageTitle' => 'Edit Invoice Item'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="text-center">
                <h1 class="m-0">Edit Invoice Item</h1>
                <p>for <a href="{{ route('rentals.show', ['rentalUuid' => $rental->uuid]) }}" class="text-decoration-none">{{ $rental->name }}</a>, {{ $rental->location }}</p>
            </div>
            <form role="form" method="POST" action="{{ route('rentals.invoiceItems.update', ['rentalUuid' => $rental->uuid, 'invoiceItemUuid' => $invoiceItem->uuid]) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ (old('name')) ? old('name') : $invoiceItem->name }}" placeholder="Name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Amount in KSH</label>
                    <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ (old('amount')) ? old('amount') : $invoiceItem->amount }}" placeholder="Amount in KSH">
                    @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Update Invoice Item</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
