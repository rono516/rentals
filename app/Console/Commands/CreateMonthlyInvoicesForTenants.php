<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\InvoiceItem;
use App\Models\Rental;
use App\Traits\Utilities;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateMonthlyInvoicesForTenants extends Command
{
    use Utilities;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the monthly invoices for all tentants (based on a rental\'s invoice items).';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rentals = Rental::with('invoiceItems')->get();
        $this->line('Started processing invoicing of '.$rentals->count().' rentals...');

        foreach ($rentals as $rental) {
            $currentDay = now()->format('j');

            if ($rental->rent_due_day == $currentDay) {
                $invoiceItems = $rental->invoiceItems;
                $invoiceItemsArray = $invoiceItems->pluck('name')->toArray();
                $houses = $rental->houses()->where('is_vacant', false)->get();

                $this->line($rental->name.': Preparing to invoice '.$houses->count().' tenants with '.$invoiceItems->count().' invoice items each ('.implode(', ', $invoiceItemsArray).')...');

                foreach ($houses as $house) {
                    $tenantInvoices = Invoice::where([
                        ['tenant_id', '=', $house->tenant->id],
                        ['house_id', '=', $house->id],
                    ])->with('invoiceDetails')->get();

                    $currentMonth = Carbon::now()->format('m-Y');
                    $alreadyInvoicedItems = [];

                    foreach ($tenantInvoices as $tenantInvoice) {
                        $invoiceDetails = $tenantInvoice->invoiceDetails()->with('invoice')->with('invoiceItem')->get();

                        foreach ($invoiceDetails as $invoiceDetail) {
                            $invoiceMonth = $invoiceDetail->created_at->format('m-Y');

                            if ($invoiceMonth === $currentMonth) {
                                $alreadyInvoicedItems[] = $invoiceDetail->invoiceItem->id;
                            }
                        }
                    }

                    $itemsToInvoice = [];

                    foreach ($invoiceItems as $invoiceItem) {
                        if (! in_array($invoiceItem->id, $alreadyInvoicedItems)) {
                            $itemsToInvoice[] = $invoiceItem->id;
                        }
                    }

                    $totalItemsToInvoice = count($itemsToInvoice);

                    $this->line($totalItemsToInvoice.' items to invoice '.$house->tenant->user->name.' ('.$house->name.') for the month of '.$currentMonth);

                    if ($totalItemsToInvoice) {
                        $invoiceNumber = $rental->standard_name.'-'.$rental->latest_invoice_number + 1;

                        DB::transaction(function () use ($invoiceNumber, $house, $itemsToInvoice) {
                            $invoice = Invoice::create([
                                'uuid' => $this->generateUuid(),
                                'invoice_number' => $invoiceNumber,
                                'tenant_id' => $house->tenant->id,
                                'house_id' => $house->id,
                            ]);

                            $itemsToInvoice = InvoiceItem::find($itemsToInvoice);

                            foreach ($itemsToInvoice as $itemToInvoice) {
                                $amount = (is_null($itemToInvoice->amount)) ? $house->rent : $itemToInvoice->amount;

                                InvoiceDetail::create([
                                    'uuid' => $this->generateUuid(),
                                    'invoice_id' => $invoice->id,
                                    'invoice_item_id' => $itemToInvoice->id,
                                    'amount' => $amount,
                                ]);

                                $this->line('Invoiced '.$itemToInvoice->name.' with KSH '.$amount);
                            }
                        });
                    }
                }
            } else {
                $this->line('Rent processing for '.$rental->name.' not due (due on '.$rental->rent_due_day.'). Skipping...');
            }
        }

        $this->line('Invoices generated for '.$rentals->count().' rentals.');
    }
}
