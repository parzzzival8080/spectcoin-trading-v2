<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'referral_code', 'total_deposit', 'total_incentives'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}
 