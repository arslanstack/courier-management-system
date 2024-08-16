<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    protected $table = 'airports';

    protected $fillable = [
        'name',
        'city',
        'country',
        'code',
    ];
    
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_airports', 'airport_id', 'company_id');
    }
}
