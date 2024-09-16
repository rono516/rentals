<?php

namespace App\Http\Controllers;

use App\Mail\TenantAccountCreated;
use App\Models\HouseTenant;
use App\Models\Tenant;
use App\Models\User;
use App\Traits\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    use Utilities;

    public function create($rentalUuid, $houseUuid)
    {
        $this->authorize('tenants.create');

        return view('tenants.create', [
            'rental' => $this->validateRental($rentalUuid),
            'house' => $this->validateHouse($houseUuid),
        ]);
    }

    public function store(Request $request, $rentalUuid, $houseUuid)
    {
        $this->authorize('tenants.create');

        $validData = $request->validate([
            'id_number' => 'required|numeric|unique:tenants,id_number',
            'name' => 'required',
            'phone' => 'required|numeric|digits:10|unique:tenants,phone',
            'email' => 'required|email|unique:users,email',
        ]);

        $rental = $this->validateRental($rentalUuid);
        $house = $this->validateHouse($houseUuid);

        DB::transaction(function () use ($validData, $house) {
            $user = User::create([
                'uuid' => $this->generateUuid(),
                'name' => $validData['name'],
                'email' => $validData['email'],
                'password' => Hash::make(Str::random(20)),
            ]);

            $tenant = Tenant::create([
                'uuid' => $this->generateUuid(),
                'user_id' => $user->id,
                'id_number' => $validData['id_number'],
                'phone' => $validData['phone'],
                'invite_code' => $this->generateUuid(),
            ]);

            $user->assignRole('Tenant');

            HouseTenant::create([
                'house_id' => $house->id,
                'tenant_id' => $tenant->id,
            ]);

            $house->update(['is_vacant' => false]);

            Mail::to($user)->send(new TenantAccountCreated($tenant));
        });

        flash()->addSuccess('Tenant added successfully.');

        return redirect()->route('rentals.show', ['rentalUuid' => $rental->uuid]);
    }

    public function show($rentalUuid, $houseUuid, $tenantUuid)
    {
        $this->authorize('tenants.show');

        $tenant = $this->validateTenant($tenantUuid);

        return view('tenants.show', [
            'rental' => $this->validateRental($rentalUuid),
            'house' => $this->validateHouse($houseUuid),
            'tenant' => $tenant,
            'invoices' => $tenant->invoices()->with('invoiceDetails')->latest()->get(),
        ]);
    }

    public function edit($rentalUuid, $houseUuid, $tenantUuid)
    {
        $this->authorize('tenants.edit');

        return view('tenants.edit', [
            'rental' => $this->validateRental($rentalUuid),
            'house' => $this->validateHouse($houseUuid),
            'tenant' => $this->validateTenant($tenantUuid),
        ]);
    }

    public function update(Request $request, $rentalUuid, $houseUuid, $tenantUuid)
    {
        $this->authorize('tenants.edit');

        $tenant = $this->validateTenant($tenantUuid);

        $validData = $request->validate([
            'id_number' => ['required', 'numeric', Rule::unique('tenants')->ignore($tenant)],
            'name' => 'required',
            'phone' => ['required', 'numeric', 'digits:10', Rule::unique('tenants')->ignore($tenant)],
            'email' => ['required', 'email', Rule::unique('users')->ignore($tenant->user)],
        ]);

        $rental = $this->validateRental($rentalUuid);
        $house = $this->validateHouse($houseUuid);

        DB::transaction(function () use ($tenant, $validData) {
            $tenant->user->update([
                'name' => $validData['name'],
                'email' => $validData['email'],
            ]);

            $tenant->update([
                'id_number' => $validData['id_number'],
                'phone' => $validData['phone'],
            ]);
        });

        flash()->addSuccess('Tenant updated successfully.');

        return redirect()->route('rentals.houses.tenants.show', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid, 'tenantUuid' => $tenant->uuid]);
    }

    public function createPassword(Request $request, $inviteUuid)
    {
        if (! $request->email) {
            abort(403);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $tenant = $user->tenant()->where('invite_code', $inviteUuid)->firstOrFail();

        return view('tenants.setPassword', [
            'tenant' => $tenant,
        ]);
    }

    public function storePassword(Request $request, $inviteUuid)
    {
        $user = User::where('email', $request->email)->firstOrFail();
        $tenant = $user->tenant()->where('invite_code', $inviteUuid)->firstOrFail();

        $validData = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        DB::transaction(function () use ($user, $validData, $tenant) {
            $user->update([
                'password' => Hash::make($validData['password']),
                'email_verified_at' => now(),
            ]);

            $tenant->update([
                'invite_code' => null,
            ]);
        });

        flash()->addSuccess('Password set successfully.');

        return redirect()->route('login');
    }
}
