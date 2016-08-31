<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // manully tell laravel to use a table
	protected $table = 'categories';

	public function posts()
	{
		return $this->hasMany('App\Post');
	}
}
