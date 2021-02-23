<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['rating', 'comment', 'master_id'];

    public function master(){
        return $this->belongsTo(Master::class);
    }

}
