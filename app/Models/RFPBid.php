<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RFPBid extends Model
{
    use HasFactory;

    protected $table = 'rfp_bids';

    protected $fillable = [
        'rfp_id',
        'user_id',
        'company_id'.
        'amount',
        'terms',
        'status',
        'contact_name',
        'contact_phone',
        'contact_email',
    ];

    public function rfp()
    {
        return $this->belongsTo(RFP::class, 'rfp_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }
}
