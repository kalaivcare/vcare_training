<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accreditation extends Model
{
	protected $table = 'accreditations';
	
    protected $fillable = [
        'name', 'image', 'status',
    ];
}
