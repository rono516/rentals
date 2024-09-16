@extends('layouts.app', ['pageTitle' => 'View Tenant'])

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-4">
            @include('tenants.partials.tenantCard')
        </div>
        <div class="col-12 col-md-8">
            @include('invoices.index')
        </div>
    </div>
</div>
@endsection
