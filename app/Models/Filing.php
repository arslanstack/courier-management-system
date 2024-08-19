<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filing extends Model
{
    use HasFactory;

    protected $table = 'filings';

    protected $fillable = [
        'type',
        'company_id',
        'user_id',
        'post_id',
        'city',
        'state',
        'note',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post(){
        $table = '';
        switch($this->type){
            case 0:
                $table = 'companies';
                break;
            case 1:
                $table = 'quote_requests';
                break;
            case 2:
                $table = 'vehicles';
                break;
            case 3:
                $table = 'rfps';
                break;
        }

        return $this->belongsTo($table, 'post_id', 'id');
    }
 
}
