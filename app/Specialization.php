<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    protected $fillable = ['specialization_name'];

    public function specializations(){
        return $this->hasMany(Master::class);
    }
}
