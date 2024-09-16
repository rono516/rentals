<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\InvoicePaymentRequest;
use App\Models\User;
use App\Traits\Payments;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    use Payments;

    public function create($rentalUuid, $houseUuid, $tenantUuid, $invoiceUuid)
    {
        $tenant = $this->validateTenant($tenantUuid);
        $invoice = $tenant->invoices()->where('uuid', $invoiceUuid)->firstOrFail();

        return view('payments.create', [
            'rental' => $this->validateRental($rentalUuid),
            'house' => $this->validateHouse($houseUuid),
            'tenant' => $tenant,
            'invoice' => $invoice,
        ]);
    }

    public function store(Request $request, $rentalUuid, $houseUuid, $tenantUuid, $invoiceUuid)
    {
        $rental = $this->validateRental($rentalUuid);
        $house = $this->validateHouse($houseUuid);
        $tenant = $this->validateTenant($tenantUuid);
        $invoice = $tenant->invoices()->where('uuid', $invoiceUuid)->firstOrFail();

        $validData = $request->validate([
            'amount' => 'required|numeric',
            'phone' => 'required|numeric',
        ]);

        $response = $this->stkPush('254'.$validData['phone'], $validData['amount']);

        if (is_object($response)) {
            try {
                InvoicePaymentRequest::create([
                    'user_id' => $tenant->user->id,
                    'invoice_id' => $invoice->id,
                    'phone' => $request->phone,
                    'amount' => $request->amount,
                    'merchant' => $response->merchant,
                    'checkout' => $response->checkout,
                ]);

                flash()->addSuccess('A payment request of KSH '.$validData['amount'].' sent to '.$validData['phone'].'.');

                return redirect()->route('rentals.houses.tenants.show', ['rentalUuid' => $rental->uuid, 'houseUuid' => $house->uuid, 'tenantUuid' => $tenant->uuid]);
            } catch (Exception $ex) {
                Log::error($ex);

                flash()->addWarning('Could not save the payment request.');

                return redirect()->back();
            }
        } else {
            flash()->addWarning('Could not send payment request.');

            return redirect()->back();
        }
    }

    /**
     * MPESA STK callback URL.
     *
     * @param  Request  $request
     * @return void
     */
    public function stkCallback(Request $request)
    {
        if ($request->isMethod('post')) {
            $meta = $this->stkCallbackData();

            if ($meta) {
                try {
                    $paymentRequest = InvoicePaymentRequest::where('merchant', $meta['merchantRequestID'])
                        ->where('checkout', $meta['checkoutRequestID'])
                        ->first();

                    if (is_null($paymentRequest)) {
                        Log::error('Payment request not found. Merchant: '.$meta['merchantRequestID'].', Checkout: '.$meta['checkoutRequestID']);
                    } else {
                        $user = User::findOrFail($paymentRequest->user_id);
                        $invoice = Invoice::findOrFail($paymentRequest->invoice_id);

                        DB::transaction(function () use ($user, $invoice, $meta, $paymentRequest) {
                            InvoicePayment::create([
                                'user_id' => $user->id,
                                'invoice_id' => $invoice->id,
                                'merchant' => $meta['merchantRequestID'],
                                'checkout' => $meta['checkoutRequestID'],
                                'receipt' => $meta['mpesaReceiptNumber'],
                                'phone' => $meta['phoneNumber'],
                                'amount' => $meta['amount'],
                                'date' => $meta['transactionDate'],
                            ]);

                            $invoice->update([
                                'paid_at' => now(),
                            ]);

                            $paymentRequest->delete();
                        });

                        Log::info('Payment entry saved.');
                    }
                } catch (Exception $ex) {
                    Log::error('Saving the payment entry failed.');
                    Log::error($ex);
                }

                Log::info('===');
            } else {
                Log::error('Invalid meta from callback: '.print_r($meta, true));
                Log::info('===');
            }
        } else {
            Log::error('STK callback was not a POST request.');
            Log::info('===');
        }
    }
}
