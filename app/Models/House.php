<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class House extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'uuid',
        'name',
        'rent',
        'is_vacant',
        'rental_id',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function getTenantAttribute()
    {
        $latestHouseTenant = HouseTenant::where('house_id', $this->id)->latest()->first();

        if ($latestHouseTenant) {
            return $latestHouseTenant->tenant;
        } else {
            return $latestHouseTenant;
        }
    }
}
