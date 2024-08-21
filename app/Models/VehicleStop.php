<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleStop extends Model
{
    use HasFactory;

    protected $table = 'vehicle_stops';


    protected $fillable = [
        'vehicle_post_id',
        'city',
        'state',
        'zip',
        'lat',
        'lng',
        'arrival',
    ];

    public function vehiclePost()
    {
        return $this->belongsTo(VehiclePost::class);
    }
}
