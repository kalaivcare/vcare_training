<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{

    protected $table = 'otps';

    protected $fillable = [
        'id',
        'mobile',
        'otp',
        'expires_at',
        'created_at',
        'updated_at'

    ];
}
