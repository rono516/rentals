<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TenantAccountCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $tenant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Tenant Account Created')
            ->with([
                'rental' => $this->tenant->house->rental,
            ])
            ->markdown('emails.tenants.welcome');
    }
}
