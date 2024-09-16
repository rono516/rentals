<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Rental extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'uuid',
        'name',
        'location',
        'rent_due_day',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function houses()
    {
        return $this->hasMany(House::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getStandardNameAttribute()
    {
        $nameArray = explode(' ', $this->name);
        $standardName = strtolower(implode('-', $nameArray));

        return $standardName;
    }

    public function getLatestInvoiceNumberAttribute()
    {
        $rental = $this->with('houses')->first();
        $allHousesIDs = $rental->houses->pluck('id');
        $allHousesWithTenants = HouseTenant::whereIn('house_id', $allHousesIDs)->pluck('house_id');
        $allInvoices = Invoice::whereIn('house_id', $allHousesWithTenants)->latest()->pluck('invoice_number');
        $latestInvoiceNumber = count($allInvoices);

        return $latestInvoiceNumber;
    }
}
