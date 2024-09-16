<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Rental;
use App\Models\Tenant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Check if a rental exists and it belongs to the currently
     * logged in user.
     */
    protected function validateRental($rentalUuid)
    {
        if (auth()->user()->hasRole('Landlord')) {
            $rental = auth()->user()->rentals()->where('uuid', $rentalUuid)->firstOrFail();
        } else {
            $rental = Rental::where('uuid', $rentalUuid)->firstOrFail();
        }

        return $rental;
    }

    /**
     * Check if a house exists and it belongs to the currently
     * logged in user.
     */
    protected function validateHouse($houseUuid)
    {
        $house = House::where('uuid', $houseUuid)->firstOrFail();

        if (auth()->user()->hasRole('Landlord')) {
            $owner = $house->rental->user;

            if (auth()->user()->id != $owner->id) {
                abort(403);
            }
        }

        return $house;
    }

    /**
     * Check if a tenant exists and was added by the currently
     * logged in user.
     */
    protected function validateTenant($tenantUuid)
    {
        $tenant = Tenant::where('uuid', $tenantUuid)->firstOrFail();

        if (auth()->user()->hasRole('Landlord')) {
            $rentalOwner = $tenant->house->rental->user;

            if ($rentalOwner->id !== auth()->user()->id) {
                abort(403);
            }
        }

        return $tenant;
    }
}
