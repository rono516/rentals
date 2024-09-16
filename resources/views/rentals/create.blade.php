@extends('layouts.app', ['pageTitle' => 'Create Rental'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <h1 class="text-center">Create Rental</h1>
            <form role="form" method="POST" action="{{ route('rentals.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Location</label>
                    <input id="location" type="text" class="form-control @error('location') is-invalid @enderror" name="location" value="{{ old('location') }}" placeholder="Location">
                    @error('location')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Rent Due Day</label>
                    <input id="rent_due_day" type="number" class="form-control @error('rent_due_day') is-invalid @enderror" name="rent_due_day" value="{{ old('rent_due_day') }}" placeholder="Rent Due Day">
                    @error('rent_due_day')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Add Rental</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
