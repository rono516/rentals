@extends('layouts.app', ['pageTitle' => 'Create House'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="text-center">
                <h1 class="m-0">Create House</h1>
                <p>in <a href="{{ route('rentals.show', ['rentalUuid' => $rental->uuid]) }}" class="text-decoration-none">{{ $rental->name }}</a>, {{ $rental->location }}</p>
            </div>
            <form role="form" method="POST" action="{{ route('rentals.houses.store', ['rentalUuid' => $rental->uuid]) }}">
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
                    <label class="form-label">Rent in KSH</label>
                    <input id="rent" type="number" class="form-control @error('rent') is-invalid @enderror" name="rent" value="{{ old('rent') }}" placeholder="Rent in KSH">
                    @error('rent')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Add House</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
