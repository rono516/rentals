<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class InvoicePaymentRequest extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'invoice_id',
        'phone',
        'amount',
        'merchant',
        'checkout',
    ];
}
