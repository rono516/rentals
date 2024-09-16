@extends('layouts.app', ['pageTitle' => 'Invoice items for ' . $rental->name])

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <p class="text-end">
                <a href="{{ route('rentals.invoiceItems.create', ['rentalUuid' => $rental->uuid]) }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Add Invoice Item
                </a>
            </p>
            <h1 class="m-0">Invoice Items</h1>
            <p>
                for
                <a href="{{ route('rentals.show', ['rentalUuid' => $rental->uuid]) }}" class="text-decoration-none">{{ $rental->name }}</a>
                ({{ $rental->location }})
            </p>
            @if ($invoiceItems->count())
                <table class="table" id="datatable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Created On</th>
                            <th scope="col">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoiceItems as $index => $invoiceItem)
                            <tr>
                                <th scope="row">{{ ++$index }}</th>
                                <td>{{ $invoiceItem->name }}</td>
                                <td>{{ ($invoiceItem->required) ? 'N/A' : 'KSH ' . $invoiceItem->amount }}</td>
                                <td title="{{ $invoiceItem->created_at->diffForHumans() }}">{{ $invoiceItem->created_at->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    @if (!$invoiceItem->required)
                                        <a href="{{ route('rentals.invoiceItems.delete', ['rentalUuid' => $rental->uuid, 'invoiceItemUuid' => $invoiceItem->uuid]) }}" class="text-danger text-decoration-none">Delete</a>
                                        -
                                        <a href="{{ route('rentals.invoiceItems.edit', ['rentalUuid' => $rental->uuid, 'invoiceItemUuid' => $invoiceItem->uuid]) }}" class="text-decoration-none">Edit</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h3 class="text-center my-10">{{ $rental->name }} does not have any invoice items.</h3>
            @endif
        </div>
    </div>
</div>
@endsection
