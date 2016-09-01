<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    public function posts()
    {
    	return $this->belongsToMany('App\Post');
    	//return $this->belongsToMany('App\Post','name_of_table','tag_id','post_id');
    }
}
