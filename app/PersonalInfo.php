<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
  	public function User(){
        $this->belongsTo('App\User','user_id','id');
    }

}
