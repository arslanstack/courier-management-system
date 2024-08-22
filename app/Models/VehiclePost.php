<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiclePost extends Model
{
    use HasFactory;

    protected $table = 'vehicle_posts';

    protected $fillable = [
        'user_id',
        'company_id',
        'route_type',
        'vehicle_type',
        'date_available',
        'start_city',
        'start_state',
        'start_zip',
        'start_lat',
        'start_lng',
        'departure',
        'destination_city',
        'destination_state',
        'destination_zip',
        'destination_lat',
        'destination_lng',
        'arrival',
        'mileage',
        'reefer',
        'liftgate',
        'hazmat',
        'round_trip',
        'other_info',
        'contact_name',
        'contact_phone',
        'contact_email',
        'status',
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function VehicleStop()
    {
        return $this->hasMany(VehicleStop::class);
    }
}
