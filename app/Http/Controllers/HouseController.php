<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Traits\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HouseController extends Controller
{
    use Utilities;

    public function create($rentalUuid)
    {
        $this->authorize('houses.create');

        return view('houses.create', [
            'rental' => $this->validateRental($rentalUuid),
        ]);
    }

    public function store(Request $request, $rentalUuid)
    {
        $this->authorize('houses.create');

        $validData = $request->validate([
            'name' => 'required',
            'rent' => 'required|numeric',
        ]);

        $rental = $this->validateRental($rentalUuid);

        $validData['uuid'] = $this->generateUuid();
        $validData['rental_id'] = $rental->id;

        House::create($validData);

        flash()->addSuccess('House added successfully.');

        return redirect()->route('rentals.show', ['rentalUuid' => $rental->uuid]);
    }

    public function show($rentalUuid, $houseUuid)
    {
        $this->authorize('houses.show');

        return view('houses.show', [
            'rental' => $this->validateRental($rentalUuid),
            'house' => $this->validateHouse($houseUuid),
        ]);
    }

    public function edit($rentalUuid, $houseUuid)
    {
        $this->authorize('houses.edit');

        return view('houses.edit', [
            'rental' => $this->validateRental($rentalUuid),
            'house' => $this->validateHouse($houseUuid),
        ]);
    }

    public function update(Request $request, $rentalUuid, $houseUuid)
    {
        $this->authorize('houses.edit');

        $rental = $this->validateRental($rentalUuid);
        $house = $this->validateHouse($houseUuid);

        $validData = $request->validate([
            'name' => 'required',
            'rent' => 'required|numeric',
        ]);

        $house->update($validData);

        flash()->addSuccess('House updated successfully.');

        return redirect()->route('rentals.show', ['rentalUuid' => $rental->uuid]);
    }

    public function delete($rentalUuid, $houseUuid)
    {
        $this->authorize('houses.delete');

        $house = $this->validateHouse($houseUuid);

        if ($house->tenant) {
            flash()->addWarning('Vacate the house before deleting it.');

            return redirect()->route('rentals.show', ['rentalUuid' => $house->rental->uuid]);
        }

        return view('houses.delete', [
            'rental' => $this->validateRental($rentalUuid),
            'house' => $house,
        ]);
    }

    public function destroy($rentalUuid, $houseUuid)
    {
        $this->authorize('houses.delete');

        $rental = $this->validateRental($rentalUuid);
        $house = $this->validateHouse($houseUuid);

        if ($house->tenant) {
            flash()->addWarning('Vacate the house before deleting it.');

            return redirect()->route('rentals.show', ['rentalUuid' => $house->rental->uuid]);
        }

        $house->delete();

        flash()->addSuccess('House deleted successfully.');

        return redirect()->route('rentals.show', ['rentalUuid' => $rental->uuid]);
    }

    public function vacate($rentalUuid, $houseUuid)
    {
        $this->authorize('houses.vacate');

        $house = $this->validateHouse($houseUuid);

        if (! $house->tenant) {
            flash()->addWarning('The house does not have a tenant.');

            return redirect()->route('rentals.show', ['rentalUuid' => $house->rental->uuid]);
        }

        return view('houses.vacate', [
            'rental' => $this->validateRental($rentalUuid),
            'house' => $house,
        ]);
    }

    public function vacateStore(Request $request, $rentalUuid, $houseUuid)
    {
        $this->authorize('houses.vacate');

        $rental = $this->validateRental($rentalUuid);
        $house = $this->validateHouse($houseUuid);

        if (! $house->tenant) {
            flash()->addWarning('The house does not have a tenant.');

            return redirect()->route('rentals.show', ['rentalUuid' => $house->rental->uuid]);
        }

        DB::transaction(function () use ($house) {
            $house->tenant->user->delete();
            $house->update(['is_vacant' => true]);
        });

        flash()->addSuccess('House vacated and tenant deleted successfully.');

        return redirect()->route('rentals.show', ['rentalUuid' => $rental->uuid]);
    }
}
