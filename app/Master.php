<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Master extends Model
{
    protected $fillable = ['first_name', 'last_name', 'gender', 'specialization_id', 'company_id', 'city',
        'description','img', 'user_id'];

    public function specialization(){
        return $this->belongsTo(Specialization::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);//hasMany
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
