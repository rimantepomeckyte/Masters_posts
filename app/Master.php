<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    protected $fillable = ['first_name', 'last_name', 'gender', 'specialization_id', 'company_id', 'city',
        'description','img', 'user_id'];
}
