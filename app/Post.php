<?php

namespace site;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $guarded = [];
	// posts has many comments
	// returns all comments on that post
	public function comments()
	{
		return $this->hasMany('site\Comment');
	}
	// returns the instance of the user who is author of that post
	public function user()
	{
		return $this->belongsTo('site\User');
	}
}
