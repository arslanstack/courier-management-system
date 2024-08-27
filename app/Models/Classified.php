<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classified extends Model
{
    use HasFactory;

    protected $table = 'classifieds';

    protected $fillable = [
        'user_id',
        'company_id',
        'screen_name',
        'title',
        'description',
        'location',
        'state',
        'category',
        'photo',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
