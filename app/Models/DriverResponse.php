<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverResponse extends Model
{
    use HasFactory;

    protected $table = 'driver_responses';

    protected $fillable = [
        'driver_ad_id',
        'company_id',
        'user_id',
        'name',
        'city',
        'state',
        'vehicle_types',
        'contact_email',
        'contact_phone',
        'message',
        'status',
    ];

    public function driverAd()
    {
        return $this->belongsTo(DriverAd::class, 'driver_ad_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
