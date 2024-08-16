<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RFP extends Model
{
    use HasFactory;

    protected $table = 'rfps';

    protected $fillable = [
        'user_id',
        'route_type',
        'multiple_routes',
        'vehicle_type',
        'reefer',
        'hazmat',
        'status',
        'lift_gate',
        'start_point',
        'delivery_point',
        'description',
        'frequency',
        'payment_terms',
        'estimated_mileage',
        'insurance_coverage',
        'bid_per_stop',
        'bid_per_route',
        'other_requirements',
        'bid_due',
        'recipients',
        'doc_1',
        'doc_2',
        'contact_company',
        'contact_name',
        'contact_phone',
        'contact_email',
        'start_city',
        'start_state',
        'start_zip',
        'lat',
        'long',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
