<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverContactList extends Model
{
    use HasFactory;

    protected $table = 'driver_contact_lists';

    protected $fillable = [
        'user_id',
        'company_id',
        'driver_ad_id',
        'driver_response_id',
        'email_sent'
    ];  

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function driverAd(){
        return $this->belongsTo(DriverAd::class);
    }

    public function driverResponse(){
        return $this->belongsTo(DriverResponse::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }
}
