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
        'alert_rpf',
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
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
