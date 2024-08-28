<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'chat_id',
        'sender_id',
        'sender_company_id',
        'receiver_id',
        'receiver_company_id',
        'message',
        'is_read',
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

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
}
