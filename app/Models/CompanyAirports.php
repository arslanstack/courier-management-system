<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAirports extends Model
{
    use HasFactory;

    protected $table = 'company_airports';

    protected $fillable = [
        'company_id',
        'airport_id',
        'operation_active',
    ];
}
