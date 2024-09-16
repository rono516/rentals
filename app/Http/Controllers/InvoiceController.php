<?php

namespace App\Http\Controllers;

use App\Models\HouseTenant;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Traits\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    use Utilities;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function create($rentalUuid, $houseUuid, $tenantUuid)
    {
        $this->authorize('invoices.create');

        $rental = $this->validateRental($rentalUuid);

        return view('invoices.create', [
            'rental' => $rental,
            'house' => $this->validateHouse($houseUuid),
            'tenant' => $this->validateTenant($tenantUuid),
            'invoiceItems' => $rental->invoiceItems,
        ]);
    }

    public function store(Request $request, $rentalUuid, $houseUuid, $tenantUuid)
    {
        $this->authorize('invoices.create');

        $validData = $request->validate([
            'invoice_item' => 'required',
            'amount' => 'required|numeric',
        ]);

        $rental = $this->validateRental($rentalUuid);
        $house = $this->validateHouse($houseUuid);
        $tenant = $this->validateTenant($tenantUuid);

        $houseTenant = HouseTenant::where('house_id', $tenant->house->id)->where('tenant_id', $tenant->id)->firstOrFail();

        $invoiceNumber = $rental->standard_name.'-'.$rental->latest_invoice_number + 1;

        DB::transaction(function () use ($validData, $houseTenant, $invoiceNumber) {
            $invoice = Invoice::create([
                'uuid' => $this->generateUuid(),
                'invoice_number' => $invoiceNumber,
                'tenant_id' => $houseTenant->tenant_id,
                'house_id' => $houseTenant->house_id,
            ]);

            InvoiceDetail::create([
                'uuid' => $this->generateUuid(),
                'invoice_id' => $invoice->id,
                'invoice_item_id' => $validData['invoice_item'],
                'amount' => $validData['amount'],
            ]);
        });

        flash()->addSuccess('Invoice created successfully.');

        return redirect()->route('rentals.houses.tenants.show', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid, 'tenantUuid' => $tenant->uuid]);
    }

    public function show($rentalUuid, $houseUuid, $tenantUuid, $invoiceUuid)
    {
        $this->authorize('invoices.show');

        $tenant = $this->validateTenant($tenantUuid);

        $invoice = $tenant->invoices()->where('uuid', $invoiceUuid)->with('invoiceDetails')->firstOrFail();

        return view('invoices.show', [
            'rental' => $this->validateRental($rentalUuid),
            'house' => $this->validateHouse($houseUuid),
            'tenant' => $tenant,
            'invoice' => $invoice,
            'invoiceDetails' => $invoice->invoiceDetails()->with('invoiceItem')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
