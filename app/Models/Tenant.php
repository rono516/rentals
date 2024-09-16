<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Tenant extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'uuid',
        'user_id',
        'id_number',
        'phone',
        'invite_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getHouseAttribute()
    {
        $latestTenantHouse = HouseTenant::where('tenant_id', $this->id)->latest()->first();

        if ($latestTenantHouse) {
            return $latestTenantHouse->house;
        } else {
            return $latestTenantHouse;
        }
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
