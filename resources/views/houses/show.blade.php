@extends('layouts.app', ['pageTitle' => $house->name . ' in ' . $rental->name . ' Rental'])

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h3>{{ $house->name }} Tenants in {{ $rental->name }}, {{ $rental->location }}</h3>
            <pre>
                @php print_r($house->tenant) @endphp
            </pre>
        </div>
    </div>
</div>
@endsection
