<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteBids extends Model
{
    use HasFactory;

    protected $table = 'quote_bids';

    protected $fillable = [
        'user_id',
        'company_id',
        'request_id',
        'amount',
        'contact_fname',
        'contact_lname',
        'contact_phone',
        'contact_email',
        'terms',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function request()
    {
        return $this->belongsTo(QuoteRequest::class, 'request_id');
    }
}
