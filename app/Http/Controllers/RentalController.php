<?php

namespace App\Http\Controllers;

use App\Models\InvoiceItem;
use App\Models\Rental;
use App\Traits\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RentalController extends Controller
{
    use Utilities;

    public function index()
    {
        $this->authorize('rentals.index');

        $rentals = auth()->user()->rentals()->latest()->get();

        return view('rentals.index', [
            'rentals' => $rentals,
        ]);
    }

    public function create()
    {
        $this->authorize('rentals.create');

        return view('rentals.create');
    }

    public function store(Request $request)
    {
        $this->authorize('rentals.create');

        $validData = $request->validate([
            'name' => 'required|unique:rentals,name',
            'location' => 'required',
            'rent_due_day' => 'required|integer|between:1,28',
        ]);

        $validData['uuid'] = $this->generateUuid();
        $validData['user_id'] = auth()->user()->id;

        $rental = DB::transaction(function () use ($validData) {
            $rental = Rental::create($validData);

            InvoiceItem::create([
                'uuid' => $this->generateUuid(),
                'name' => 'Rent',
                'required' => true,
                'rental_id' => $rental->id,
            ]);

            return $rental;
        });

        flash()->addSuccess('Rental added successfully.');

        return redirect()->route('rentals.show', ['rentalUuid' => $rental->uuid]);
    }

    public function show($rentalUuid)
    {
        $this->authorize('rentals.show');

        $rental = $this->validateRental($rentalUuid);

        return view('rentals.show', [
            'rental' => $rental,
            'houses' => $rental->houses()->latest()->get(),
            'invoiceItems' => $rental->invoiceItems()->get()->pluck('name')->toArray(),
        ]);
    }

    public function edit($rentalUuid)
    {
        $this->authorize('rentals.edit');

        return view('rentals.edit', [
            'rental' => $this->validateRental($rentalUuid),
        ]);
    }

    public function update(Request $request, $rentalUuid)
    {
        $this->authorize('rentals.edit');

        $rental = $this->validateRental($rentalUuid);

        $validData = $request->validate([
            'name' => ['required', Rule::unique('rentals')->ignore($rental->id)],
            'location' => 'required',
            'rent_due_day' => 'required|integer|between:1,28',
        ]);

        $rental->update($validData);

        flash()->addSuccess('Rental updated successfully.');

        return redirect()->route('rentals.show', ['rentalUuid' => $rental->uuid]);
    }

    public function delete($rentalUuid)
    {
        $this->authorize('rentals.delete');

        $rental = $this->validateRental($rentalUuid);

        if ($rental->houses()->count()) {
            flash()->addWarning('Delete all existing houses before deleting this rental.');

            return redirect()->route('rentals.show', ['rentalUuid' => $rental->uuid]);
        }

        return view('rentals.delete', [
            'rental' => $rental,
        ]);
    }

    public function destroy($rentalUuid)
    {
        $this->authorize('rentals.delete');
        
        $rental = $this->validateRental($rentalUuid);

        if ($rental->houses()->count()) {
            flash()->addWarning('Delete all existing houses before deleting this rental.');

            return redirect()->route('rentals.show', ['rentalUuid' => $rental->uuid]);
        }

        $rental->delete();

        flash()->addSuccess('Rental deleted successfully.');

        return redirect()->route('rentals.index');
    }
}
