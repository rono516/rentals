<?php

namespace App\Http\Controllers;

use App\Models\InvoiceItem;
use App\Traits\Utilities;
use Illuminate\Http\Request;

class InvoiceItemController extends Controller
{
    use Utilities;

    public function index($rentalUuid)
    {
        $this->authorize('invoiceItems.index');

        $rental = $this->validateRental($rentalUuid);

        return view('invoiceItems.index', [
            'rental' => $rental,
            'invoiceItems' => $rental->invoiceItems()->latest()->get(),
        ]);
    }

    public function create($rentalUuid)
    {
        $this->authorize('invoiceItems.create');

        $rental = $this->validateRental($rentalUuid);

        return view('invoiceItems.create', [
            'rental' => $rental,
        ]);
    }

    public function store(Request $request, $rentalUuid)
    {
        $this->authorize('invoiceItems.create');

        $validData = $request->validate([
            'name' => 'required',
            'amount' => 'required|numeric',
        ]);

        $rental = $this->validateRental($rentalUuid);

        $validData['uuid'] = $this->generateUuid();
        $validData['rental_id'] = $rental->id;

        InvoiceItem::create($validData);

        flash()->addSuccess('Invoice item added successfully.');

        return redirect()->route('rentals.invoiceItems.index', ['rentalUuid' => $rental->uuid]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($rentalUuid, $invoiceItemUuid)
    {
        $this->authorize('invoiceItems.edit');

        $rental = $this->validateRental($rentalUuid);
        $invoiceItem = $rental->invoiceItems()->where('uuid', $invoiceItemUuid)->firstOrFail();

        if ($invoiceItem->required) {
            flash()->addWarning('You cannot edit this invoice item.');

            return redirect()->route('rentals.invoiceItems.index', ['rentalUuid' => $rental->uuid]);
        }

        return view('invoiceItems.edit', [
            'rental' => $rental,
            'invoiceItem' => $invoiceItem,
        ]);
    }

    public function update(Request $request, $rentalUuid, $invoiceItemUuid)
    {
        $this->authorize('invoiceItems.edit');

        $validData = $request->validate([
            'name' => 'required',
            'amount' => 'required|numeric',
        ]);

        $rental = $this->validateRental($rentalUuid);
        $invoiceItem = $rental->invoiceItems()->where('uuid', $invoiceItemUuid)->firstOrFail();

        if ($invoiceItem->required) {
            flash()->addWarning('You cannot edit this invoice item.');

            return redirect()->route('rentals.invoiceItems.index', ['rentalUuid' => $rental->uuid]);
        }

        $invoiceItem->update($validData);

        flash()->addSuccess('Invoice item updated successfully.');

        return redirect()->route('rentals.invoiceItems.index', ['rentalUuid' => $rental->uuid]);
    }

    public function delete($rentalUuid, $invoiceItemUuid)
    {
        $this->authorize('invoiceItems.delete');

        $rental = $this->validateRental($rentalUuid);
        $invoiceItem = $rental->invoiceItems()->where('uuid', $invoiceItemUuid)->firstOrFail();

        if ($invoiceItem->required) {
            flash()->addWarning('You cannot delete this invoice item.');

            return redirect()->route('rentals.invoiceItems.index', ['rentalUuid' => $rental->uuid]);
        }

        return view('invoiceItems.delete', [
            'rental' => $rental,
            'invoiceItem' => $invoiceItem,
        ]);
    }

    public function destroy($rentalUuid, $invoiceItemUuid)
    {
        $this->authorize('invoiceItems.delete');
        
        $rental = $this->validateRental($rentalUuid);
        $invoiceItem = $rental->invoiceItems()->where('uuid', $invoiceItemUuid)->firstOrFail();

        if ($invoiceItem->required) {
            flash()->addWarning('You cannot delete this invoice item.');

            return redirect()->route('rentals.invoiceItems.index', ['rentalUuid' => $rental->uuid]);
        }

        $invoiceItem->delete();

        flash()->addSuccess('Invoice item deleted successfully.');

        return redirect()->route('rentals.invoiceItems.index', ['rentalUuid' => $rental->uuid]);
    }
}
