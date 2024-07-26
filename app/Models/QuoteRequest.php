<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    use HasFactory;

    protected $table = 'quote_requests';

    protected $fillable = [
        'pickup_date',
        'pickup_time',
        'start_point',
        'pickup_address_1',
        'pickup_address_2',
        'pickup_city',
        'pickup_state',
        'pickup_zip',
        'pickup_contact_name',
        'pickup_contact_phone',
        'pickup_contact_email',
        'pickup_company',
        'delivery_point',
        'delivery_time',
        'delivery_address_1',
        'delivery_address_2',
        'delivery_city',
        'delivery_state',
        'delivery_zip',
        'delivery_contact_name',
        'delivery_contact_phone',
        'delivery_contact_email',
        'delivery_company',
        'estimated_mileage',
        'weight',
        'dimensions',
        'description',
        'vehicle',
        'reefer',
        'hazmat',
        'lift_gate',
        'user_id',
        'company_id',
        'transaction_id',
        'delivery_country',
        'pickup_country',
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

    public function transaction()
    {
        // return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
