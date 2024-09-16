<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;
use Safaricom\Mpesa\Mpesa;

trait Payments
{
    /**
     * Send an STK push request to a recipient.
     *
     * @param $phone
     * @param $amount
     * @return bool|object
     */
    public function stkPush($phone, $amount)
    {
        $mpesa = new Mpesa();

        $businessShortCode = config('mpesa.shortCode');
        $lipaNaMpesaPasskey = config('mpesa.passKey');
        $transactionType = 'CustomerPayBillOnline';
        $partyB = config('mpesa.shortCode');
        $callBackURL = config('mpesa.callbackURL');
        $accountReference = $phone;
        $transactionDesc = 'Paying an invoice in '.config('app.name');
        $remarks = '';

        try {
            Log::info('Sending an STK push request to '.$phone.'...');

            $json = $mpesa->STKPushSimulation($businessShortCode, $lipaNaMpesaPasskey, $transactionType, $amount, $phone, $partyB, $phone, $callBackURL, $accountReference, $transactionDesc, $remarks);
            $response = json_decode($json);

            if (property_exists($response, 'CheckoutRequestID') && $response->ResponseCode == 0) {
                Log::info($response->ResponseDescription.'.');

                return (object) [
                    'merchant' => $response->MerchantRequestID,
                    'checkout' => $response->CheckoutRequestID,
                ];
            } elseif (property_exists($response, 'errorCode')) {
                Log::error($response->errorMessage.'.');

                return false;
            } else {
                Log::info('Response: '.print_r($response, true));

                return false;
            }
        } catch (Exception $exception) {
            Log::error($exception);

            return false;
        }
    }

    /**
     * Process the callback from Safaricom
     */
    public function stkCallbackData()
    {
        Log::info('MPESA callback received.');

        $mpesa = new Mpesa();
        $response = json_decode($mpesa->getDataFromCallback());
        $stk = $response->Body->stkCallback;

        if ($stk->ResultCode == 0) {
            $meta = $stk->CallbackMetadata->Item;

            foreach ($meta as $item) {
                if (property_exists($item, 'Value')) {
                    if ($item->Name == 'MpesaReceiptNumber') {
                        $metaBuild['mpesaReceiptNumber'] = $item->Value;
                    } elseif ($item->Name == 'PhoneNumber') {
                        $metaBuild['phoneNumber'] = $item->Value;
                    } elseif ($item->Name == 'Amount') {
                        $metaBuild['amount'] = $item->Value;
                    } elseif ($item->Name == 'TransactionDate') {
                        $metaBuild['transactionDate'] = $item->Value;
                    }
                }
            }

            $metaBuild['merchantRequestID'] = $stk->MerchantRequestID;
            $metaBuild['checkoutRequestID'] = $stk->CheckoutRequestID;

            Log::info($stk->ResultDesc);

            return $metaBuild;
        } else {
            Log::info($stk->ResultDesc);

            return false;
        }
    }
}
