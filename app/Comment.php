<?php

namespace site;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	//comments table in database
	protected $guarded = [];
	// user who has commented
	public function user()
	{
		return $this->belongsTo('site\User');
	}
	// returns post of any comment
	public function post()
	{
		return $this->belongsTo('site\Post');
	}
}