@extends('layouts.app', ['pageTitle' => 'Edit Tenant'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="text-center">
                <h1 class="m-0">Edit Tenant</h1>
                <p>in <a href="{{ route('rentals.show', ['rentalUuid' => $rental->uuid]) }}" class="text-decoration-none">{{ $rental->name }}</a>, {{ $rental->location }}</p>
            </div>
            <form role="form" method="POST" action="{{ route('rentals.houses.tenants.update', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid, 'tenantUuid' => $tenant->uuid]) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">ID Number</label>
                    <input id="id_number" type="number" class="form-control @error('id_number') is-invalid @enderror" name="id_number" value="{{ (old('id_number')) ? old('id_number') : $tenant->id_number }}" placeholder="ID Number" autofocus>
                    @error('id_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ (old('name')) ? old('name') : $tenant->user->name }}" placeholder="Name">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input id="phone" type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ (old('phone')) ? old('phone') : $tenant->phone }}" placeholder="Phone">
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ (old('email')) ? old('email') : $tenant->user->email }}" placeholder="Email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Update Tenant</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
