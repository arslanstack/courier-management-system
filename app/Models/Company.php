<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'mail_address_1',
        'mail_address_2',
        'image',
        'city',
        'state',
        'country',
        'zip',
        'company_type',
        'motor_carrier_no',
        'dot_no',
        'intrastate_no',
        'alert_email_1',
        'alert_email_2',
        'alert_freight',
        'alert_vehicle',
        'alert_rfp',
        'alert_driver',
        'website',
        'drivers',
        'insurance_company',
        'gen_liability',
        'cargo_insurance',
        'other_insurance',
        'insurance_declaration',
        'insurance_expiration',
        'company_phone',
        'company_mobile',
        'account_type',
        'billing_info_status',
        'card_number',
        'cvv',
        'expiry_month',
        'expiry_year',
        'lat',
        'long',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function quoteRequests()
    {
        return $this->hasMany(QuoteRequest::class);
    }

    public function quoteBids()
    {
        return $this->hasMany(QuoteBids::class);
    }

    public function companyProfile()
    {
        return $this->hasOne(CompanyProfile::class, 'company_id', 'id');
    }

    public function companyAirports()
    {
        return $this->hasMany(CompanyAirports::class, 'company_id', 'id');
    }
    
    public function Warehouses()
    {
        return $this->hasMany(Warehouse::class, 'company_id', 'id');
    }

    public function vehiclePosts()
    {
        return $this->hasMany(VehiclePost::class, 'company_id', 'id');
    }

    public function driverAds()
    {
        return $this->hasMany(DriverAd::class, 'company_id', 'id');
    }
}
