<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverAd extends Model
{
    use HasFactory;

    protected $table = 'driver_ads';

    protected $fillable = [
        'user_id',
        'company_id',
        'type',
        'compensation',
        'compensation_type',
        'vehicle_types',
        'reefer',
        'hazmat',
        'lift_gate',
        'tsa_certified',
        'city',
        'state',
        'zip',
        'experience',
        'insurance_coverage',
        'company_name',
        'show_company_name',
        'ad_title',
        'description',
        'response_info',
        'company_logo',
        'contact_email',
        'div_id',
        'fee',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function responses(){
        return $this->hasMany(DriverResponse::class, 'driver_ad_id');
    }
}
