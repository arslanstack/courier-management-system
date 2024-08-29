<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'quote_request_id',
        'sender_company_id',
        'receiver_company_id',
    ];  

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function senderCompany()
    {
        return $this->belongsTo(Company::class, 'sender_company_id');
    }

    public function receiverCompany()
    {
        return $this->belongsTo(Company::class, 'receiver_company_id');
    }

    public function quoteRequest(){
        return $this->belongsTo(QuoteRequest::class, 'quote_request_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_id');
    }
}
